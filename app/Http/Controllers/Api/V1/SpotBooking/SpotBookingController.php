<?php

namespace App\Http\Controllers\Api\V1\SpotBooking;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreSpotBookingRequest;
use App\Models\SpotBooking;
use App\Models\User;
use App\Models\BlockStation;

use App\Services\SpotBooking\SpotBookingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpotBookingController extends BaseController
{
    protected $spotBookingService;

    public function __construct(SpotBookingService $spotBookingService)
    {

        $this->spotBookingService = $spotBookingService;
    }

    /* ────── LIST ────── */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $booking = $this->spotBookingService->paginate($perPage);
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
            : $this->sendError('Booking not found.', $errorMessages = [], 404);
    }

    /* ────── STORE ────── */
    public function store(StoreSpotBookingRequest $request)
    {

        try {
            // code...
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
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            // 'reschedule_note'          => 'required',
            // 'rescheduled_by'          => 'required|in:artist,studio',
        ]);
        if ($data->fails()) {
            return $this->sendError($data->errors()->first(), $errorMessages = [], 422);
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
            // code...
            $booking = $this->spotBookingService->approve($id);
            if (! $booking) {
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

    public function monthlyCalendar1(Request $request, $studioId)
    {

        $validator = Validator::make($request->all(), [
            'month' => 'nullable|integer|min:1|max:12',
            'year' => 'nullable|integer|min:2000|max:2100',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $errorMessages = [], 422);

        }
        $month = $request->input('month') ?: now()->month;
        $year = $request->input('year') ?: now()->year;

        $studio = User::find($studioId);

        if (! $studio) {
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
            ->with('artist:id,name,last_name,avatar')
            ->get();

        $calendar = [];
        $daysInMonth = now()->setYear($year)->setMonth($month)->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
            $calendar[$date] = [
                'booked' => 0,
                'total' => $studio->total_stations,
                'booking_ids' => [],
                'stations' => [],
                'artists' => [],
                'status' => 'free', // default
            ];
        }
        
        foreach ($bookings as $booking) {
            $start = Carbon::parse($booking->start_date);
            $end = Carbon::parse($booking->end_date);

            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $dayKey = $date->format('Y-m-d');
                     
                if (isset($calendar[$dayKey])) {
                    $calendar[$dayKey]['booked']++;
                    $calendar[$dayKey]['booking_ids'][] = $booking->id;
                    $calendar[$dayKey]['stations'][] = $booking->station_number;
                    $calendar[$dayKey]['artists'][] = $booking->artist;
 
                    // update status dynamically
                    if ($calendar[$dayKey]['booked'] >= $calendar[$dayKey]['total']) {
                        $calendar[$dayKey]['status'] = 'fully';
                    } elseif ($calendar[$dayKey]['booked'] > 0) {
                        $calendar[$dayKey]['status'] = 'partial';
                    }
                }
            }
        }

        return $this->sendResponse($calendar, 'Monthly calendar data.');
    }
    public function monthlyCalendar(Request $request, $studioId)
{
    $validator = Validator::make($request->all(), [
        'month' => 'nullable|integer|min:1|max:12',
        'year'  => 'nullable|integer|min:2000|max:2100',
    ]);

    if ($validator->fails()) {
        return $this->sendError($validator->errors()->first(), [], 422);
    }

    $month = $request->input('month') ?: now()->month;
    $year  = $request->input('year') ?: now()->year;

    $studio = User::find($studioId);

    if (! $studio) {
        return $this->sendError('Studio not found.');
    }

    $totalStations = $studio->total_stations;

    // --- 1. Get bookings ---
    $bookings = SpotBooking::where('studio_id', $studioId)
        ->where('status', 'approved')
        ->where(function ($q) use ($month, $year) {
            $q->whereMonth('start_date', $month)
              ->whereYear('start_date', $year)
              ->orWhereMonth('end_date', $month)
              ->whereYear('end_date', $year);
        })
        ->with('artist:id,name,last_name,avatar')
        ->get();

    // --- 2. Get blocked stations ---
    $blockedStations = BlockStation::where('studio_id', $studioId)
        ->where(function ($q) use ($month, $year) {
            $q->whereMonth('start_date', $month)
              ->whereYear('start_date', $year)
              ->orWhereMonth('end_date', $month)
              ->whereYear('end_date', $year);
        })
        ->get();

    // --- 3. Initialize calendar ---
    $calendar = [];
    $daysInMonth = now()->setYear($year)->setMonth($month)->daysInMonth;

    for ($day = 1; $day <= $daysInMonth; $day++) {
        $date = sprintf('%04d-%02d-%02d', $year, $month, $day);

        // Pre-fill all stations as free
        $stations = [];
        for ($s = 1; $s <= $totalStations; $s++) {
            $stations[$s] = [
                'status'         => 'free',
                'station_number' => $s,
                'booking_id'     => null,
                'artist'         => null,
                'start_date'     => null,
                'end_date'       => null,
                'reason'         => null,
            ];
        }

        $calendar[$date] = [
            'booked'   => 0,
            'total'    => $totalStations,
            'stations' => $stations,
            'status'   => 'free',
        ];
    }

    // --- 4. Apply bookings ---
    foreach ($bookings as $booking) {
        $start = Carbon::parse($booking->start_date);
        $end   = Carbon::parse($booking->end_date);

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $dayKey = $date->format('Y-m-d');

            if (isset($calendar[$dayKey])) {
                $stationNum = $booking->station_number;

                $calendar[$dayKey]['stations'][$stationNum] = [
                    'status'         => 'booked',
                    'station_number' => $stationNum,
                    'booking_id'     => $booking->id,
                    'artist'         => $booking->artist,
                    'start_date'     => $booking->start_date,
                    'end_date'       => $booking->end_date,
                    'reason'         => null,
                ];

                // increment booked count
                $calendar[$dayKey]['booked']++;
            }
        }
    }

    // --- 5. Apply blocked stations ---
    foreach ($blockedStations as $block) {
        $start = Carbon::parse($block->start_date);
        $end   = Carbon::parse($block->end_date);

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $dayKey = $date->format('Y-m-d');

            if (isset($calendar[$dayKey])) {
                $stationNum = $block->station_number;

                $calendar[$dayKey]['stations'][$stationNum] = [
                    'status'         => 'blocked',
                    'station_number' => $stationNum,
                    'booking_id'     => null,
                    'artist'         => null,
                    'start_date'     => $block->start_date,
                    'end_date'       => $block->end_date,
                    'reason'         => $block->reason,
                ];
            }
        }
    }

    // --- 6. Update daily status (free / partial / fully / blocked) ---
    foreach ($calendar as $date => &$dayData) {
        $statuses = collect($dayData['stations'])->pluck('status');

        if ($statuses->every(fn($s) => $s === 'free')) {
            $dayData['status'] = 'free';
        } elseif ($statuses->every(fn($s) => $s === 'booked')) {
            $dayData['status'] = 'fully';
        } elseif ($statuses->every(fn($s) => $s === 'blocked')) {
            $dayData['status'] = 'blocked';
        } else {
            $dayData['status'] = 'partial';
        }
    }

    return $this->sendResponse($calendar, 'Monthly calendar with per-station details.');
}

    public function monthlyCalendar2(Request $request, $studioId)
    {
        $validator = Validator::make($request->all(), [
            'month' => 'nullable|integer|min:1|max:12',
            'year'  => 'nullable|integer|min:2000|max:2100',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), [], 422);
        }

        $month = $request->input('month') ?: now()->month;
        $year  = $request->input('year') ?: now()->year;

        $studio = User::find($studioId);

        if (! $studio) {
            return $this->sendError('Studio not found.');
        }

        $totalStations = $studio->total_stations;

        // --- 1. Get bookings ---
        $bookings = SpotBooking::where('studio_id', $studioId)
            ->where('status', 'approved')
            ->where(function ($q) use ($month, $year) {
                $q->whereMonth('start_date', $month)
                ->whereYear('start_date', $year)
                ->orWhereMonth('end_date', $month)
                ->whereYear('end_date', $year);
            })
            ->with('artist:id,name,last_name,avatar')
            ->get();

        // --- 2. Get blocked stations ---
        $blockedStations = BlockStation::where('studio_id', $studioId)
            ->where(function ($q) use ($month, $year) {
                $q->whereMonth('start_date', $month)
                ->whereYear('start_date', $year)
                ->orWhereMonth('end_date', $month)
                ->whereYear('end_date', $year);
            })
            ->get();

        // --- 3. Initialize calendar ---
        $calendar = [];
        $daysInMonth = now()->setYear($year)->setMonth($month)->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = sprintf('%04d-%02d-%02d', $year, $month, $day);

            // Pre-fill all stations as free
            $stations = [];
            for ($s = 1; $s <= $totalStations; $s++) {
                $stations[$s] = [
                    'status' => 'free',
                    'artist' => null,
                    'reason' => null,
                ];
            }

            $calendar[$date] = [
                'total'    => $totalStations,
                'stations' => $stations,
                'status'   => 'free',
            ];
        }

        // --- 4. Apply bookings ---
        foreach ($bookings as $booking) {
            $start = Carbon::parse($booking->start_date);
            $end   = Carbon::parse($booking->end_date);

            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $dayKey = $date->format('Y-m-d');

                if (isset($calendar[$dayKey])) {
                    $stationNum = $booking->station_number;
                    $calendar[$dayKey]['stations'][$stationNum] = [
                        'status'     => 'booked',
                        'booking_id' => $booking->id,
                        'artist'     => $booking->artist,
                        'start_date' => $booking->start_date,
                        'end_date'   => $booking->end_date,
                        'reason'     => null,
                    ];
                }
            }
        }

        // --- 5. Apply blocked stations ---
        foreach ($blockedStations as $block) {
            $start = Carbon::parse($block->start_date);
            $end   = Carbon::parse($block->end_date);

            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $dayKey = $date->format('Y-m-d');

                if (isset($calendar[$dayKey])) {
                    $stationNum = $block->station_number;
                    $calendar[$dayKey]['stations'][$stationNum] = [
                        'status'     => 'blocked',
                        'booking_id' => null,
                        'artist'     => null,
                        'start_date' => $block->start_date,
                        'end_date'   => $block->end_date,
                        'reason'     => $block->reason,
                    ];
                }
            }
        }

        // --- 6. Update daily status (free / partial / fully / blocked) ---
        foreach ($calendar as $date => &$dayData) {
            $statuses = collect($dayData['stations'])->pluck('status')->unique();

            if ($statuses->count() === 1 && $statuses->first() === 'free') {
                $dayData['status'] = 'free';
            } elseif ($statuses->count() === 1 && $statuses->first() === 'booked') {
                $dayData['status'] = 'fully';
            } elseif ($statuses->count() === 1 && $statuses->first() === 'blocked') {
                $dayData['status'] = 'blocked';
            } else {
                $dayData['status'] = 'partial';
            }
        }

        return $this->sendResponse($calendar, 'Monthly calendar with per-station details.');
    }


}

