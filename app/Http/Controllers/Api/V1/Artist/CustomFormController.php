<?php

namespace App\Http\Controllers\Api\V1\Artist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\API\Artist\CustomFormRepositoryInterface;
use App\Http\Requests\API\Artist\StoreCustomFormRequest;
use App\Http\Requests\API\Artist\UpdateCustomFormRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\ClientBookingForm;
use App\Models\SpotBooking;
use App\Http\Controllers\Api\BaseController as BaseController;
class CustomFormController extends BaseController
{
    protected $formRepo;
    public function __construct(CustomFormRepositoryInterface $formRepo)
    {
        $this->formRepo = $formRepo;
    }

    public function store(StoreCustomFormRequest $request)
    {
        $validated = $request->validated();
        $validated['artist_id'] = auth()->id();

        $form = $this->formRepo->create($validated);
        return $this->sendResponse($form, 'Form created successfully.', 201);
        try {
        } catch (\Throwable $e) {
            return $this->sendError('Something went wrong.', 500);
        }
    }


    public function index()
    {
        $artistId = auth()->id();
        $forms = $this->formRepo->getByArtist($artistId);
        return $this->sendResponse($forms, 'Forms fetched successfully.');
    }

    public function show($id)
    {
        try {
            $form = $this->formRepo->getById($id);
            return $this->sendResponse($form, 'Form fetched successfully.');
        } catch (\Throwable $e) {
            return $this->sendError('Form not found.', 404);
        }
    }

    public function update(UpdateCustomFormRequest $request, $id)
    {

        if (is_null($id)) {
            return $this->sendError('Form ID is required.', 400);
        }

        try {
            $form = $this->formRepo->update($id, $request->validated());

            if (!$form) {
                return $this->sendError('Form not found.', 404);
            }

            return $this->sendResponse($form, 'Form updated successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong.', 500);
        }
    }

    public function destroy($id)
    {

        $form = $this->formRepo->getById($id);

        if (!$form) {
            return $this->sendError('Form not found.', 404);
        }
        try {

            $this->formRepo->delete($id);
            return $this->sendResponse([], 'Form deleted successfully.');

        } catch (\Exception $e) {
            return $this->sendError('Something went wrong.', 500);
        }
    }

    public function bookingUrl(Request $request){
        $validator = Validator::make($request->all(), [
            'studio_id'    => 'required|exists:users,id',
            'custom_form_id' => 'required|exists:custom_forms,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|date_format:H:i:s',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        try {
            // 🔹 Find matching spot booking
            $spotBooking = SpotBooking::where('studio_id', $request->studio_id)
                ->whereDate('start_date', '<=', $request->booking_date)
                ->whereDate('end_date', '>=', $request->booking_date)
                ->first();

            if (!$spotBooking) {
                return $this->sendError('No matching spot booking found for this date.');
            }

            $data = ClientBookingForm::create([
                'artist_id' => auth()->id(),
                'studio_id' => $request->studio_id,
                'spot_booking_id' => $spotBooking->id ?? null,
                'custom_form_id' => $request->custom_form_id,
                'booking_date' => $request->booking_date,
                'booking_time' => $request->booking_time,
                'booking_url' => "booking/".auth()->id()."/".auth()->user()->name."/",
                'status' => 'creating',
            ]);

            return $this->sendResponse($data, 'Booking URL created successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong.', 500);
        }
    }


}
