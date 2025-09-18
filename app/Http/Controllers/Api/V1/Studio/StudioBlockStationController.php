<?php

namespace App\Http\Controllers\Api\V1\Studio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\BaseController as BaseController; 

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\BlockStation;
class StudioBlockStationController extends BaseController
{
    public function index(Request $request)
    {
        $studioId = auth()->user()->id; // assuming studio is logged in
        $data = BlockStation::where('studio_id', $studioId)->get();
        return $this->sendResponse($data, 'Block stations fetched successfully.');
         
    }

    public function store(Request $request)
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
