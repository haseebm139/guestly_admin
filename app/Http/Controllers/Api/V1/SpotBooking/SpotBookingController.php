<?php

namespace App\Http\Controllers\API\V1\SpotBooking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\SpotBooking\SpotBookingService;
use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Rules\StudioExists;
use App\Http\Requests\StoreSpotBookingRequest ;
use App\Http\Requests\RescheduleSpotBookingRequest ;

class SpotBookingController extends BaseController
{

    protected $spotBookingService;


    public function __construct(SpotBookingService  $spotBookingService)
    {

        $this->spotBookingService = $spotBookingService;
    }
     /* ────── LIST ────── */
    public function index(Request $request)
    {
        $perPage  = $request->get('per_page', 10);
        $booking  = $this->spotBookingService->paginate($perPage);
        try {

            return $this->sendResponse($booking, 'Bookings fetched.');
        } catch (\Throwable $th) {
            return $this->sendError('Failed to fetch bookings.', 500);
        }
    }


    /* ────── SHOW ────── */
    public function show(int $id)
    {
        $booking = $this->spotBookingService->find($id);

        return $booking
            ? $this->sendResponse($booking, 'Booking found.')
            : $this->sendError('Booking not found.',$errorMessages=[], 404);
    }

    /* ────── STORE ────── */
    public function store(StoreSpotBookingRequest  $request)
    {


        $data = $request->validated();
        $booking = $this->spotBookingService->create($data);
        return $this->sendResponse($booking, 'Booking request sent.', 201);
    }

    /* ────── RESCHEDULE ────── */
    public function reschedule(Request $request, int $id)
    {


        $data = Validator::make($request->all(), [
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after_or_equal:start_date',
            'reschedule_note'          => 'required',
            'rescheduled_by'          => 'required|in:artist,studio',
        ]);
         if ($data->fails()) {
            return $this->sendError($data->errors()->first(),$errorMessages = [], 422);
        }

        $data = $data->validated();
        return $this->spotBookingService->reschedule($id, $data)
            ? $this->sendResponse(null, 'Booking rescheduled.')
            : $this->sendError('Booking not found.', [], 404);
    }

    /* ────── APPROVE ────── */
    public function approve(int $id)
    {
        return $this->spotBookingService->approve($id)
            ? $this->sendResponse(null, 'Booking approved.')
            : $this->sendError('Booking not found.', 404);
    }

    /* ────── REJECT ────── */
    public function reject(int $id)
    {
        return $this->spotBookingService->reject($id)
            ? $this->sendResponse(null, 'Booking rejected.')
            : $this->sendError('Booking not found.', 404);
    }




}
