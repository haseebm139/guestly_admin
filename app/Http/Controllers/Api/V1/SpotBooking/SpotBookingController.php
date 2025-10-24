<?php

namespace App\Http\Controllers\Api\V1\SpotBooking;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreSpotBookingRequest;
use App\Models\BlockStation;
use App\Models\SpotBooking;
use App\Models\StudioWeeklyAvailability;
use App\Models\StudioUnavailableDate;
use App\Models\ClientBookingForm;


use App\Models\User;
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

    public function monthlyCalendar(Request $request, $studioId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'month' => 'nullable|integer|min:1|max:12',
                'year' => 'nullable|integer|min:2000|max:2100',
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first(), [], 422);
            }

            $month = $request->input('month') ?: now()->month;
            $year = $request->input('year') ?: now()->year;

            $studio = User::find($studioId);

            if (! $studio) {
                return $this->sendError('Studio not found.');
            }

            $totalStations = $studio->total_stations;
            // --- Get weekly availability ---
            $weeklyAvailability = StudioWeeklyAvailability::where('studio_id', $studioId)
                ->pluck('is_available', 'day_of_week')
                ->toArray(); // ['monday' => 1, 'tuesday' => 0, ...]
            // --- Studio unavailable dates ---
            $unavailableDates = StudioUnavailableDate::where('studio_id', $studioId)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->pluck('reason', 'date'); // ['2025-09-06' => 'Maintenance']
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
                $dayName = strtolower(Carbon::parse($date)->format('l'));

                $isAvailable = (bool) ($weeklyAvailability[$dayName] ?? true);
                $reason = $isAvailable ? 'Working day' : 'Holiday';

            if (isset($unavailableDates[$date])) {
                    // If the studio is marked unavailable for this specific date,
                    // force the day availability to false and set the reason accordingly.
                    $isAvailable = false;
                    $reason = $unavailableDates[$date];
                }
                // Pre-fill all stations as free
                $stations = [];
                for ($s = 1; $s <= $totalStations; $s++) {
                    $stations[$s] = [
                        'status' => 'free',
                        'station_number' => $s,
                        'booking_id' => null,
                        'artist' => null,
                        'start_date' => null,
                        'end_date' => null,
                        'reason' => null,
                    ];
                }

                $calendar[$date] = [
                    'booked' => 0,
                    'total' => $totalStations,
                    'stations' => $stations,
                    'status' => $isAvailable ? 'free' : 'blocked',
                    'studio_availability' => (bool) $isAvailable,
                    'reason' => $reason,
                ];

            }

            // --- 4. Apply bookings ---
            foreach ($bookings as $booking) {
                $start = Carbon::parse($booking->start_date);
                $end = Carbon::parse($booking->end_date);

                for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                    $dayKey = $date->format('Y-m-d');

                    if (isset($calendar[$dayKey])) {
                        $stationNum = $booking->station_number;

                        // If the station is currently marked blocked (rare), prefer booking info.
                        $calendar[$dayKey]['stations'][$stationNum] = [
                            'status' => 'booked',
                            'station_number' => $stationNum,
                            'booking_id' => $booking->id,
                            'artist' => $booking->artist,
                            'start_date' => $booking->start_date,
                            'end_date' => $booking->end_date,
                            'reason' => null,
                        ];

                        // increment booked count (booked OR blocked should be counted once)
                        $calendar[$dayKey]['booked']++;
                    }
                }
            }

            // --- 5. Apply blocked stations ---
            // IMPORTANT: treat blocked station as occupied (count toward booked) BUT do not double-count if already booked.
            foreach ($blockedStations as $block) {
                $start = Carbon::parse($block->start_date);
                $end = Carbon::parse($block->end_date);

                for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                    $dayKey = $date->format('Y-m-d');

                    if (! isset($calendar[$dayKey])) {
                        continue;
                    }

                    $stationNum = $block->station_number;

                    // current status of that station for this day
                    $currentStatus = $calendar[$dayKey]['stations'][$stationNum]['status'] ?? 'free';

                    if ($currentStatus === 'free') {
                        // mark blocked and increment booked counter (count as occupied)
                        $calendar[$dayKey]['stations'][$stationNum] = [
                            'status' => 'blocked',
                            'station_number' => $stationNum,
                            'booking_id' => null,
                            'artist' => null,
                            'start_date' => $block->start_date,
                            'end_date' => $block->end_date,
                            'reason' => $block->reason,
                        ];

                        $calendar[$dayKey]['booked']++;
                    } elseif ($currentStatus === 'booked') {
                        // Station already booked, keep booking info but add blocked info
                        $calendar[$dayKey]['stations'][$stationNum]['blocked_reason'] = $block->reason;
                        $calendar[$dayKey]['stations'][$stationNum]['status'] = 'blocked';
                        $calendar[$dayKey]['booked']++;
                        // Treat blocked station as booked for count purposes (already booked, so no increment)
                    } else {
                        // If it's already 'booked' (a real booking exists), keep booking info and do NOT increment again.
                        // If you want to record that a booked station also had a block, you could attach a flag or reason here.
                    }
                }
            }

            // --- 6. Update daily status (free / partial / fully / blocked) ---
            foreach ($calendar as $date => &$dayData) {
                // count how many stations are not free (booked or blocked)
                $statuses = collect($dayData['stations'])->pluck('status');
                $unavailableCount = $statuses->filter(fn ($s) => $s !== 'free')->count();
                $availableCount = $dayData['total'] - $unavailableCount;

                // set counts for frontend (optional but handy)
                $dayData['stations_available'] = $availableCount;
                $dayData['stations_unavailable'] = $unavailableCount;

                // determine day-level status
                if ($availableCount === $dayData['total']) {
                    $dayData['status'] = 'free';
                } elseif ($unavailableCount === $dayData['total'] && $statuses->every(fn ($s) => $s === 'blocked')) {
                    // if every station is blocked (no actual bookings)
                    $dayData['status'] = 'blocked';
                } elseif ($unavailableCount === $dayData['total']) {
                    // all stations occupied (booked or blocked) => fully occupied
                    $dayData['status'] = 'fully';
                } else {
                    $dayData['status'] = 'partial';
                }
            }

            return $this->sendResponse($calendar, 'Monthly calendar with per-station details.');
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage() ?? 'Something went wrong.');
        }
    }

    public function clientBookingCalendar(Request $request)
    {
         
        try {
            $validator = Validator::make($request->all(), [
                'month' => 'nullable|integer|min:1|max:12',
                'year' => 'nullable|integer|min:2000|max:2100',
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first(), [], 422);
            }

            $month = $request->input('month') ?: now()->month;
            $year = $request->input('year') ?: now()->year;
            $artistId = auth()->id();
            $artist = User::where('user_type', 'artist')->where('id', $artistId)->first();

            if (!$artist) {
                return $this->sendError('Artist not found.');
            }
             
            // Get client booking forms for the specified month/year for this artist
            $clientBookings = ClientBookingForm::where('artist_id', $artistId)
                ->whereMonth('booking_date', $month)
                ->whereYear('booking_date', $year)
                ->with([
                    'client',
                    'artist',
                    'studio',
                ])
                ->get();

            // Initialize calendar
            $calendar = [];
            $daysInMonth = now()->setYear($year)->setMonth($month)->daysInMonth;

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
                
                $dayBookings = $clientBookings->filter(function ($booking) use ($date) {
                    return $booking->booking_date === $date;
                });

                $calendar[$date] = [
                    'date' => $date,
                    'day' => $day,
                    'day_name' => Carbon::parse($date)->format('l'),
                    'total_bookings' => $dayBookings->count(),
                    'bookings' => $dayBookings->map(function ($booking) {
                        return [
                            'id' => $booking->id,
                            'shared_code' => $booking->shared_code,
                            'booking_date' => $booking->booking_date,
                            'booking_time' => $booking->booking_time,
                            'duration' => $booking->duration,
                            'hourly_rate' => $booking->hourly_rate,
                            'deposit' => $booking->deposit,
                            'estimate_start' => $booking->estimate_start,
                            'estimate_end' => $booking->estimate_end,
                            'notes' => $booking->notes,
                            'status' => $booking->status,
                            'cancel_reason' => $booking->cancel_reason,
                            'client' => $booking->client ??null,
                            'artist' => $booking->artist  ??null,
                            'studio' => $booking->studio ??null,
                            'created_at' => $booking->created_at,
                            'updated_at' => $booking->updated_at,
                        ];
                    }),
                ];
            }

            // Add summary statistics
            $summary = [
                'total_bookings' => $clientBookings->count(),
                'by_status' => $clientBookings->groupBy('status')->map->count(),
                'by_studio' => $clientBookings->groupBy('studio_id')->map(function ($bookings) {
                    return [
                        'studio_name' => $bookings->first()->studio->name ?? 'Unknown Studio',
                        'total_bookings' => $bookings->count(),
                        'by_status' => $bookings->groupBy('status')->map->count(),
                    ];
                }),
            ];

            return $this->sendResponse([
                'calendar' => $calendar,
                'summary' => $summary,
                'month' => $month,
                'year' => $year,
                'artist' => [
                    'id' => $artist->id,
                    'name' => $artist->name,
                    'last_name' => $artist->last_name,
                    'avatar' => $artist->avatar,
                ]
            ], 'Artist booking calendar retrieved successfully.');

        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage() ?? 'Something went wrong.');
        }
    }

    public function monthlyCalendar1(Request $request, $studioId)
    {
        $validator = Validator::make($request->all(), [
            'month' => 'nullable|integer|min:1|max:12',
            'year' => 'nullable|integer|min:2000|max:2100',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), [], 422);
        }

        $month = $request->input('month') ?: now()->month;
        $year = $request->input('year') ?: now()->year;

        $studio = User::find($studioId);

        if (! $studio) {
            return $this->sendError('Studio not found.');
        }

        $totalStations = $studio->total_stations;
        // --- Get weekly availability ---
        $weeklyAvailability = StudioWeeklyAvailability::where('studio_id', $studioId)
            ->pluck('is_available', 'day_of_week')
            ->toArray(); // ['monday' => 1, 'tuesday' => 0, ...]
        // --- Studio unavailable dates ---
        $unavailableDates = StudioUnavailableDate::where('studio_id', $studioId)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->pluck('reason', 'date'); // ['2025-09-06' => 'Maintenance']
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
            $dayName = strtolower(Carbon::parse($date)->format('l'));

            $isAvailable = (bool) ($weeklyAvailability[$dayName] ?? true);
            $reason = $isAvailable ? 'Working day' : 'Holiday';

            if (isset($unavailableDates[$date])) {
                // Specific date is unavailable: mark not available and carry the reason.
                $isAvailable = false;
                $reason = $unavailableDates[$date];
            }
            // Pre-fill all stations as free
            $stations = [];
            for ($s = 1; $s <= $totalStations; $s++) {
                $stations[$s] = [
                    'status' => 'free',
                    'station_number' => $s,
                    'booking_id' => null,
                    'artist' => null,
                    'start_date' => null,
                    'end_date' => null,
                    'reason' => null,
                ];
            }

            $calendar[$date] = [
                'booked' => 0,
                'total' => $totalStations,
                'stations' => $stations,
                'status' => $isAvailable ? 'free' : 'blocked',
                'stations_available' => $isAvailable ? $totalStations : 0,
                'stations_unavailable' => $isAvailable ? 0 : $totalStations,
                'studio_availability' => (bool) $isAvailable,
                'reason' => $reason,
            ];

        }

        // --- 4. Apply bookings ---
        foreach ($bookings as $booking) {
            $start = Carbon::parse($booking->start_date);
            $end = Carbon::parse($booking->end_date);

            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $dayKey = $date->format('Y-m-d');

                if (isset($calendar[$dayKey])) {
                    $stationNum = $booking->station_number;

                    // If the station is currently marked blocked (rare), prefer booking info.
                    $calendar[$dayKey]['stations'][$stationNum] = [
                        'status' => 'booked',
                        'station_number' => $stationNum,
                        'booking_id' => $booking->id,
                        'artist' => $booking->artist,
                        'start_date' => $booking->start_date,
                        'end_date' => $booking->end_date,
                        'reason' => null,
                    ];

                    // increment booked count (booked OR blocked should be counted once)
                    $calendar[$dayKey]['booked']++;
                }
            }
        }

        // --- 5. Apply blocked stations ---
        // IMPORTANT: treat blocked station as occupied (count toward booked) BUT do not double-count if already booked.
        foreach ($blockedStations as $block) {
            $start = Carbon::parse($block->start_date);
            $end = Carbon::parse($block->end_date);

            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $dayKey = $date->format('Y-m-d');

                if (! isset($calendar[$dayKey])) {
                    continue;
                }

                $stationNum = $block->station_number;

                // current status of that station for this day
                $currentStatus = $calendar[$dayKey]['stations'][$stationNum]['status'] ?? 'free';

                if ($currentStatus === 'free') {
                    // mark blocked and increment booked counter (count as occupied)
                    $calendar[$dayKey]['stations'][$stationNum] = [
                        'status' => 'blocked',
                        'station_number' => $stationNum,
                        'booking_id' => null,
                        'artist' => null,
                        'start_date' => $block->start_date,
                        'end_date' => $block->end_date,
                        'reason' => $block->reason,
                    ];

                    $calendar[$dayKey]['booked']++;
                } elseif ($currentStatus === 'booked') {
                    // Station already booked, keep booking info but add blocked info
                    $calendar[$dayKey]['stations'][$stationNum]['blocked_reason'] = $block->reason;
                    $calendar[$dayKey]['stations'][$stationNum]['status'] = 'blocked';
                    $calendar[$dayKey]['booked']++;
                    // Treat blocked station as booked for count purposes (already booked, so no increment)
                } else {
                    // If it's already 'booked' (a real booking exists), keep booking info and do NOT increment again.
                    // If you want to record that a booked station also had a block, you could attach a flag or reason here.
                }
            }
        }

        // --- 6. Update daily status (free / partial / fully / blocked) ---
        foreach ($calendar as $date => &$dayData) {
            // count how many stations are not free (booked or blocked)
            $statuses = collect($dayData['stations'])->pluck('status');
            $unavailableCount = $statuses->filter(fn ($s) => $s !== 'free')->count();
            $availableCount = $dayData['total'] - $unavailableCount;

            // set counts for frontend (optional but handy)
            $dayData['stations_available'] = $availableCount;
            $dayData['stations_unavailable'] = $unavailableCount;

            // determine day-level status
            if ($availableCount === $dayData['total']) {
                $dayData['status'] = 'free';
            } elseif ($unavailableCount === $dayData['total'] && $statuses->every(fn ($s) => $s === 'blocked')) {
                // if every station is blocked (no actual bookings)
                $dayData['status'] = 'blocked';
            } elseif ($unavailableCount === $dayData['total']) {
                // all stations occupied (booked or blocked) => fully occupied
                $dayData['status'] = 'fully';
            } else {
                $dayData['status'] = 'partial';
            }
        }

        return $this->sendResponse($calendar, 'Monthly calendar with per-station details.');
    }

     
}
