<?php

namespace App\Http\Controllers\API\V1\SpotBooking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\SpotBooking\SpotBookingService;
use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class SpotBookingController extends BaseController
{

    protected $service;

    public function __construct(SpotBookingService  $service)
    {

        $this->service = $service;
    }
     /* ────── LIST ────── */
    public function index(Request $request)
    {
        try {
            $perPage  = $request->get('per_page', 10);
            $booking  = $this->service->paginate($perPage);

            return $this->sendResponse($booking, 'Bookings fetched.');
        } catch (\Throwable $th) {
            return $this->sendError('Failed to fetch bookings.', 500);
        }
    }


    /* ────── SHOW ────── */
    public function show(int $id)
    {
        $booking = $this->service->find($id);

        return $booking
            ? $this->sendResponse($booking, 'Booking found.')
            : $this->sendError('Booking not found.',$errorMessages=[], 404);
    }

    /* ────── STORE ────── */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'studio_id'        => 'required|exists:users,id',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
            'is_tour_requested'=> 'boolean',
            'booking_type'     => 'required|in:solo,group',
            'group_artists'    => 'nullable|array',
            'group_artists.*'  => 'exists:users,id',
            'message'          => 'nullable|string',
        ]);
         if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),$errorMessages = [], 422);
        }
        $validated['artist_id']   = Auth::id();
        $validated['status']      = 'pending';
        $validated['portfolio_files'] = $request->portfolio_files ?? [];

        $booking = $this->service->create($validated);

        return $this->sendResponse($booking, 'Booking request sent.',$errorMessages=[], 201);
    }

    /* ────── RESCHEDULE ────── */
    public function reschedule(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'rescheduled_by'  => 'required|in:artist,studio',
            'reschedule_note' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),$errorMessages = [], 422);
        }
        return $this->service->reschedule($id, $validated)
            ? $this->sendResponse(null, 'Booking rescheduled.')
            : $this->sendError('Booking not found.',$errorMessages=[], 404);
    }

    /* ────── APPROVE ────── */
    public function approve(int $id)
    {
        return $this->service->approve($id)
            ? $this->sendResponse(null, 'Booking approved.')
            : $this->sendError('Booking not found.', 404);
    }

    /* ────── REJECT ────── */
    public function reject(int $id)
    {
        return $this->service->reject($id)
            ? $this->sendResponse(null, 'Booking rejected.')
            : $this->sendError('Booking not found.', 404);
    }

}
