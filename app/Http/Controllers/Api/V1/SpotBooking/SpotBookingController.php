<?php

namespace App\Http\Controllers\Api\V1\SpotBooking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\SpotBooking\SpotBookingService;
use App\Http\Controllers\Api\BaseController as BaseController;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Rules\StudioExists;
use App\Http\Requests\StoreSpotBookingRequest ;
use App\Http\Requests\RescheduleSpotBookingRequest ;

use App\Models\SpotBooking;
use App\Models\User;
use DB;
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

        try {
            //code...
            $data = $request->validated();
            $booking = $this->spotBookingService->create($data);
            return $this->sendResponse($booking, 'Booking request sent.', 201);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], 422);
        }
    }

    /* ────── RESCHEDULE ────── */
    public function reschedule(Request $request, int $id)
    {


        $data = Validator::make($request->all(), [
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after_or_equal:start_date',
            // 'reschedule_note'          => 'required',
            // 'rescheduled_by'          => 'required|in:artist,studio',
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
        try {
            //code...
            $booking = $this->spotBookingService->approve($id);
            if (!$booking) {
                return $this->sendError('All stations are already booked for this date range.');
            }
            return $this->sendResponse($booking, 'Booking approved and station assigned.');
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage() ?? 'Something went wrong.');
        }
        
    }

    /* ────── REJECT ────── */
    public function reject(int $id)
    {
        return $this->spotBookingService->reject($id)
            ? $this->sendResponse(null, 'Booking rejected.')
            : $this->sendError('Booking not found.', 404);
    }


     
    public function monthlyCalendar(Request $request, $studioId)
    {

        $validator = Validator::make($request->all(), [
            'month' => 'nullable|integer|min:1|max:12',
            'year'  => 'nullable|integer|min:2000|max:2100',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),$errorMessages = [], 422);
            
        }
            $month = $request->input('month') ?: now()->month;
            $year  = $request->input('year') ?: now()->year;

            $studio = User::find($studioId);

            if (!$studio) {
                return $this->sendError('Studio not found.');
            }

            // fetch approved bookings for this studio
            $bookings = SpotBooking::where('studio_id', $studioId)
                ->where('status', 'approved')
                ->where(function ($q) use ($month, $year) {
                    $q->whereMonth('start_date', $month)
                    ->whereYear('start_date', $year)
                    ->orWhereMonth('end_date', $month)
                    ->whereYear('end_date', $year);
            })
            ->get();

            $calendar = [];
            $daysInMonth = now()->setYear($year)->setMonth($month)->daysInMonth;

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
                $calendar[$date] = [
                    'booked'      => 0,
                    'total'       => $studio->total_stations,
                    'booking_ids' => [],
                ];
            }

            // expand booking ranges into daily slots
            foreach ($bookings as $booking) {
                $start = \Carbon\Carbon::parse($booking->start_date);
                $end   = \Carbon\Carbon::parse($booking->end_date);

                for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                    $dayKey = $date->format('Y-m-d');

                    if (isset($calendar[$dayKey])) {
                        $calendar[$dayKey]['booked']++;
                        $calendar[$dayKey]['booking_ids'][] = $booking->id;
                    }
                }
            }

            return $this->sendResponse($calendar, 'Monthly calendar data.');
    }

}
