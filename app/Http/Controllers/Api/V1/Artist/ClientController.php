<?php

namespace App\Http\Controllers\Api\V1\Artist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClientBookingForm;
use App\Http\Controllers\Api\BaseController as BaseController;
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
            'customForm.fields.responses',
        ])
        // ->where('status',['pending', 'approve', 'decline'])
        ->get()
        ->groupBy('status'); // group by status field

        return $this->sendResponse($all, 'All Clients requests grouped by status');
    }

    public function getClientRequest($status){
        return $data = ClientBookingForm::with([
            'studio',
            'client',
            'customForm.fields.responses',
        ])
        // ->where('artist_id', $request->artist_id)
        ->where('status', $status)->get();
    }


    public function updateStatusClientRequest($id, $status) {
        $status1 = '';
        if ($status == 'decline') {
            $status = 'cancelled';
        }elseif ($status == 'approve') {
            $status = 'confirmed';
        }else{
            return $this->sendError('Invalid status');
        }

        $data = ClientBookingForm::where('id', $id)->first();
        if (!$data) {
            return $this->sendError('Client Booking Form not found');
        }
        $data->update(['status' => $status]);
        return $this->sendResponse($data, 'Clients requests'.$status);
    }


    public function setEstimate(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'duration'       => 'nullable|integer|min:0',
            'hourly_rate'    => 'nullable|numeric|min:0',
            'deposit'        => 'nullable|numeric|min:0',
            'estimate_start' => 'nullable|numeric|min:0',
            'estimate_end'   => 'nullable|numeric|min:0|gte:estimate_start',
            'notes'          => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $validated = $validator->validated();
        $data = ClientBookingForm::findOrFail($id);
        $data->update($validated);
        return $this->sendResponse($data, 'Set estimate successfully');
    }
}



