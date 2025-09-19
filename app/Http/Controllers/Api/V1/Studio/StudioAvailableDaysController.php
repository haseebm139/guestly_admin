<?php

namespace App\Http\Controllers\Api\V1\Studio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudioWeeklyAvailability;
use App\Models\StudioUnavailableDate;
use App\Http\Controllers\Api\BaseController as BaseController; 

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class StudioAvailableDaysController extends BaseController
{
    public function storeWeeklyAvailability(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'available_days'   => 'required|array',
            'available_days.*' => 'string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $studioId = auth()->id();

        $allDays = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
        $availableDays = $request->available_days;

        foreach ($allDays as $day) {
            StudioWeeklyAvailability::updateOrCreate(
                [
                    'studio_id'   => $studioId,
                    'day_of_week' => $day,
                ],
                [
                    'is_available' => in_array($day, $availableDays),
                ]
            );
        }

        $data['available_days'] = StudioWeeklyAvailability::where('studio_id', $studioId)->where('is_available', true)->get();
        $data['unavailable_days'] = StudioWeeklyAvailability::where('studio_id', $studioId)->where('is_available', false)->get();

        return $this->sendResponse($data, 'Weekly availability saved successfully.');
    }

    
    public function getWeeklyAvailability()
    {
        $studioId = auth()->id();
        $data['available_days'] = StudioWeeklyAvailability::where('studio_id', $studioId)->where('is_available', true)->get();
        $data['unavailable_days'] = StudioWeeklyAvailability::where('studio_id', $studioId)->where('is_available', false)->get();

        return $this->sendResponse($data, 'Days fetched.');
    }

    public function storeBlockedDate(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'date'   => 'required|date|after_or_equal:today',
            'reason' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $blockedDate = StudioUnavailableDate::updateOrCreate(
            [
                'studio_id' => auth()->id(),
                'date'      => $request->date,
            ],
            [
                'reason' => $request->reason ?? 'Studio unavailable',
            ]
        );
        return $this->sendResponse($blockedDate, 'Date blocked successfully.'); 
    }

    public function unblockDate($id)
    {
        $studioId = auth()->user()->id;

        $date = StudioUnavailableDate::where('studio_id', $studioId)
            ->where('id', $id)
            ->first();

        if (! $date) {
            return $this->sendError('Date not found.');
        }

        $date->delete();

        return $this->sendResponse([], 'Date unblocked successfully.');
    }

    public function getBlockedDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'month' => 'nullable|integer|min:1|max:12',
            'year'  => 'nullable|integer|min:2000|max:2100',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $studioId = auth()->user()->id;

        $month = $request->input('month') ?: now()->month;
        $year  = $request->input('year') ?: now()->year;

        $data = StudioUnavailableDate::where('studio_id', $studioId)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date')
            ->get();

        return $this->sendResponse($data, 'Unavailable dates fetched successfully.');
    }
}
