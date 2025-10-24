<?php

namespace App\Http\Controllers\Api\V1\Studio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\BaseController as BaseController; 

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\BlockStation;
class StudioBlockStationController extends BaseController
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [             
            'status'     => 'nullable|string|in:active,inactive',
            'month'  => 'nullable|integer|min:1|max:12',
            'year'   => 'nullable|integer|min:2000|max:9999',
             
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $studioId = auth()->user()->id; // assuming studio is logged in
        $status = $request->status ?? 'active';
        
        $month = $request->month ?? now()->month;
        $year  = $request->year  ?? now()->year;

        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOfMonth   = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        $data = BlockStation::where('studio_id', $studioId)
        ->where('status', $status)
        ->where(function ($q) use ($startOfMonth, $endOfMonth) {
            $q->whereBetween('start_date', [$startOfMonth, $endOfMonth])
              ->orWhereBetween('end_date', [$startOfMonth, $endOfMonth])
              ->orWhere(function ($q2) use ($startOfMonth, $endOfMonth) {
                  // covers blocks that start before month and end after month
                  $q2->where('start_date', '<=', $startOfMonth)
                     ->where('end_date', '>=', $endOfMonth);
              });
        })
        ->get(); 
        return $this->sendResponse($data, 'Block stations fetched successfully.');
         
    }

    public function storeSingle(Request $request)
    {

        $studio = $request->user(); // authenticated studio
        // Validate request
        $validator = Validator::make($request->all(), [
            'station_number' => [
            'required',
            'integer',
                function ($attribute, $value, $fail) use ($studio) {
                    if ($value < 1) {
                        $fail("The station number must be at least 1.");
                    }
                    if ($value > $studio->total_stations) {
                        $fail("The selected station number cannot be greater than the studio's total stations ({$studio->total_stations}).");
                    }
                },
            ],
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'reason'         => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        
        $alreadyBlocked = BlockStation::where('studio_id', $studio->id)
        ->where('station_number', $request->station_number)
        ->where(function ($query) use ($request) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                  ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                  ->orWhere(function ($q) use ($request) {
                      $q->where('start_date', '<=', $request->start_date)
                        ->where('end_date', '>=', $request->end_date);
                  });
        })
        ->exists();

        if ($alreadyBlocked) {
            return $this->sendError("This station is already blocked for the selected date range.");
        }

        // Create block record
        $block = BlockStation::create([
            'studio_id'      => $studio->id,
            'station_number' => $request->station_number,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'reason'         => $request->reason,
            
        ]);

        return $this->sendResponse($block, 'Station blocked successfully.');
    }

    public function store(Request $request)
    {
        $studio = $request->user(); // authenticated studio
        
        // Validate request - expecting an array of block station data
        $validator = Validator::make($request->all(), [
            '*.station_number' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) use ($studio) {
                    if ($value < 1) {
                        $fail("The station number must be at least 1.");
                    }
                    if ($value > $studio->total_stations) {
                        $fail("The selected station number cannot be greater than the studio's total stations ({$studio->total_stations}).");
                    }
                },
            ],
            '*.start_date'     => 'required|date',
            '*.end_date'       => 'required|date|after_or_equal:*.start_date',
            '*.reason'         => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $blocks = [];
        $errors = [];

        foreach ($request->all() as $index => $blockData) {
            // Check for overlapping blocks
            $alreadyBlocked = BlockStation::where('studio_id', $studio->id)
                ->where('station_number', $blockData['station_number'])
                ->where(function ($query) use ($blockData) {
                    $query->whereBetween('start_date', [$blockData['start_date'], $blockData['end_date']])
                          ->orWhereBetween('end_date', [$blockData['start_date'], $blockData['end_date']])
                          ->orWhere(function ($q) use ($blockData) {
                              $q->where('start_date', '<=', $blockData['start_date'])
                                ->where('end_date', '>=', $blockData['end_date']);
                          });
                })
                ->exists();

            if ($alreadyBlocked) {
                $errors[] = "Station {$blockData['station_number']} is already blocked for the date range {$blockData['start_date']} to {$blockData['end_date']}.";
                continue;
            }

            // Create block record
            $block = BlockStation::create([
                'studio_id'      => $studio->id,
                'station_number' => $blockData['station_number'],
                'start_date'     => $blockData['start_date'],
                'end_date'       => $blockData['end_date'],
                'reason'         => $blockData['reason'] ?? null,
            ]);

            $blocks[] = $block;
        }

        if (!empty($errors)) {
            return $this->sendError('Some blocks could not be created: ' . implode(' ', $errors));
        }

        return $this->sendResponse($blocks, 'Stations blocked successfully.');
    }

    public function unblock(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'station_number' => 'required|integer',
            'date'     => 'required|date|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $user = $request->user();

        $block = BlockStation::where('id', $id)
            ->where('studio_id', $user->id)
            ->where('station_number', $request->station_number)
            ->where('status', 'active')
            ->first();

        if (!$block) {
            return $this->sendError('No active block record found for this station.');
        }

        $block->update([
            'status' => 'inactive',
            'end_date' =>  $request->date
        ]);

        return $this->sendResponse($block, 'Station unblocked successfully.');
    }

   
    public function destroy($id, Request $request)
    {
        $block = BlockStation::where('studio_id', auth()->user()->id)
                             ->where('id', $id)
                             ->first();

        if (!$block) {
            return $this->sendError('Block not found');
        }
             

        $block->delete();
        return $this->sendResponse([], 'Block deleted successfully.'); 
    }
}
