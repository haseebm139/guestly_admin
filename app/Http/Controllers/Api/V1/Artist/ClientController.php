<?php

namespace App\Http\Controllers\Api\V1\Artist;

use App\Http\Controllers\Api\BaseController;
use App\Models\ClientBookingForm;
use Illuminate\Http\Request;
use Validator;

class ClientController extends BaseController
{
    public function clientsRequests(Request $request)
    {
        $status = $request->status;

        if ($status) {
            // ✅ If status is provided → return filtered
            $data = $this->getClientRequest($status);

            return $this->sendResponse($data, "Clients requests with status: $status");
        }

        // ✅ If no status → return all, grouped by status
        $all = ClientBookingForm::with([
            'studio',
            'client',
            'booking',
            'responses.field',
        ])
            ->whereIn('status', ['pending', 'approve', 'decline'])
            ->get()
            ->map(function ($booking) {
                // filter responses per booking
                $booking->customForm->fields->each(function ($field) use ($booking) {
                    $field->setRelation(
                        'responses',
                        $field->responsesForBooking($booking->id)->get()
                    );
                });

                return $booking;
            })
            ->groupBy('status');

        return $this->sendResponse($all, 'All Clients requests grouped by status');
    }

    public function getClientRequest($status)
    {
        return ClientBookingForm::with([
            'studio',
            'client',
            'booking',
            'responses.field', // load fields
            ])
                ->when($status === 'approve', function ($query) {
                $query->whereIn('status', ['approve', 'approved_pending_payment']);
            }, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->get();

    }

    public function updateStatusClientRequest(Request $request,$id, $status)
    {
        // $status1 = '';
        // if ($status == 'decline') {
        //     $status = 'cancelled';
        // }elseif ($status == 'approve') {
        //     $status = 'approve';
        // }else{
        //     return $this->sendError('Invalid status');
        // }
        $cancelReason = $request->cancel_reason;
        $price = $request->price;
          
        $data = ClientBookingForm::where('id', $id)->first();
        if (! $data) {
            return $this->sendError('Client Booking Form not found');
        }

        $updateData = ['status' => $status];
        // If cancelled, require cancel_reason
        if ($status === 'decline' || $status === 'cancelled') {
            if (empty($cancelReason)) {
                return $this->sendError('Cancel reason is required when rejecting/cancelling');
            }
            $updateData['cancel_reason'] = $cancelReason;
        }
        if ($status === 'approve') {
         
            $updateData['status'] = 'approved_pending_payment';
        }
         
        $data->update($updateData);
        return $this->sendResponse($data, 'Clients Request '.$status);
    }

    public function setEstimate(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'duration' => 'nullable|integer|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            'deposit' => 'nullable|numeric|min:0',
            'estimate_start' => 'nullable|numeric|min:0',
            'estimate_end' => 'nullable|numeric|min:0|gte:estimate_start',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $validated = $validator->validated();
        $data = ClientBookingForm::findOrFail($id);
        $data->update($validated);

        return $this->sendResponse($data, 'Set estimate successfully');
    }

    public function artistCalendar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'month' => 'nullable|integer|min:1|max:12',
            'year' => 'nullable|integer|min:2000|max:2100',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), [], 422);
        }
        $artistId = auth()->id();
        $month = $request->input('month') ?: now()->month;
        $year = $request->input('year') ?: now()->year;

        // artist bookings
        $bookings = ClientBookingForm::with(['client:id,name,last_name,avatar', 'studio:id,name'])
            ->where('artist_id', $artistId)
            // ->whereIn('status', ['pending', 'approve']) // decline not blocking
            ->whereMonth('booking_date', $month)
            ->whereYear('booking_date', $year)
            ->get();

        // initialize month
        $calendar = [];
        $daysInMonth = now()->setYear($year)->setMonth($month)->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = sprintf('%04d-%02d-%02d', $year, $month, $day);

            $calendar[$date] = [
                'status' => 'free',   // free | booked | partial
                'bookings' => [],
            ];
        }

        // apply bookings
        foreach ($bookings as $booking) {
            $date = $booking->booking_date;
            if (! isset($calendar[$date])) {
                continue;
            }

            $calendar[$date]['status'] = 'booked';
            $calendar[$date]['bookings'][] = [
                'id' => $booking->id,
                'client' => $booking->client,
                'studio' => $booking->studio,
                'booking_time' => $booking->booking_time,
                'status' => $booking->status,
            ];
        }

        return $this->sendResponse($calendar, 'Artist calendar with client bookings');
    }
}
