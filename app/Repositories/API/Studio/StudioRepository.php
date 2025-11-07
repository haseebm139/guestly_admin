<?php
namespace App\Repositories\API\Studio;

use App\Models\User;
use App\Models\SpotBooking;
use Illuminate\Support\Arr;


class StudioRepository implements StudioRepositoryInterface
{
    public function updateProfile(int $userId, array $data)
    {
        $user = User::withoutGlobalScope('active')->where('id', $userId)
            ->where('user_type', 'studio')
            ->firstOrFail();
            // ✅ Upload logo

        $user->supplies()->sync($data['supplies_provided'] ?? []);
        $user->stationAmenities()->sync($data['amenities'] ?? []);
        $user->designSpecialties()->sync($data['design_specialties'] ?? []);   // ✅ NEW
        $user->update(Arr::except($data, ['supplies_provided', 'amenities', 'design_specialties','studio_images']));

        return $user->load(['supplies', 'stationAmenities','studioImages','designSpecialties','tattooStyles']);
    }



    public function getById(int $userId)
    {
        $user = User::withoutGlobalScope('active')
            ->with(['supplies', 'stationAmenities', 'studioImages','designSpecialties','activeSubscription.plan'])->where('id', $userId)
            ->where('user_type', 'studio')
            ->firstOrFail();

        $user->supplies_provided = json_decode($user->supplies_provided);
        $user->amenities = json_decode($user->amenities);

        return $user;
    }

    public function saveGalleryImages(int $userId, array $paths): void
    {
        $user = User::findOrFail($userId);

        foreach ($paths as $path) {
            $user->studioImages()->create([
                'image_path' => $path,
            ]);
        }
    }
    public function getGuests(int $userId, string $range, int $perPage){
        $today = now();

        // Determine the date range based on the $range parameter
        [$startDate, $endDate] = match($range) {
            'today' => [$today->copy()->startOfDay(), $today->copy()->endOfDay()],
            'week'  => [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()],
            '15days'=> [$today->copy()->subDays(7)->startOfDay(), $today->copy()->addDays(7)->endOfDay()],
            'month' => [$today->copy()->startOfDay(), $today->copy()->addDays(30)->endOfDay()],
            default => [$today->copy()->startOfDay(), null], // all upcoming
        };

        $query = SpotBooking::where('studio_id', $userId)
        ->where('status', 'approved')
        ->when($endDate, function ($q) use ($startDate, $endDate) {
            $q->where(function ($q2) use ($startDate, $endDate) {
                $q2->whereBetween('start_date', [$startDate, $endDate])
                   ->orWhereBetween('end_date', [$startDate, $endDate])
                   ->orWhere(function ($q3) use ($startDate, $endDate) {
                       $q3->where('start_date', '<', $startDate)
                          ->where('end_date', '>', $endDate);
                   });
            });
        }, function ($q) use ($startDate) {
            // Default: all upcoming from today
            $q->where('start_date', '>=', $startDate);
        })
        ->with(['studio', 'artist'])
        ->orderBy('start_date');


        $data['guests'] = $query->paginate($perPage);


        return $data;
    }
    public function getTodayGuests1(int $userId, string $range, int $perPage)
    {

        return $data = SpotBooking::where('studio_id', $userId)->where('status', 'approved')

        ->where(function ($query) {
            $query->whereDate('start_date', today())
            ->orWhereDate('end_date', today())
            ->orWhere(function ($subQuery) {
                $subQuery->whereDate('start_date', '<', today())
                ->whereDate('end_date', '>', today());
            });
        })->paginate(20);


    }


    public function getUpcomingGuests(int $studioId, int $perPage = 20)
    {
        $today = now()->startOfDay();

        $query = SpotBooking::where('studio_id', $studioId)
            ->where('status', 'approved')
            ->where('start_date', '>', $today)
            ->with(['studio', 'artist']);

        return $query->orderBy('start_date')->paginate($perPage);
    }

    public function getRequestsByStatus(int $studioId, string $status, int $perPage)
    {
        return SpotBooking::where('studio_id', $studioId)
            ->where('status', $status)
            ->with([
                'artist',
                'studio'
            ])
            ->orderByDesc('start_date')
            ->paginate($perPage);
    }


}
