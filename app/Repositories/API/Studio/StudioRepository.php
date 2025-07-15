<?php
namespace App\Repositories\API\Studio;

use App\Models\User;
use App\Models\SpotBooking;
use Illuminate\Support\Arr;


class StudioRepository implements StudioRepositoryInterface
{
    public function updateProfile(int $userId, array $data)
    {
        $user = User::where('id', $userId)
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
        $user = User::with(['supplies', 'stationAmenities', 'studioImages'])->where('id', $userId)
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
        $startDate = $today;
        $endDate = $today;

        switch ($range) {
            case 'week':
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
                break;
            case '15days':
                $startDate = now()->subDays(7);
                $endDate = now()->addDays(7);
                break;
            case 'month':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'today':
            default:
                $startDate = $today;
                $endDate = $today;
                break;
        }

        $query = SpotBooking::where('studio_id', $userId)
        ->where('status', 'approved')
        ->where(function ($q) use ($startDate, $endDate) {
            $q->whereBetween('start_date', [$startDate, $endDate])
              ->orWhereBetween('end_date', [$startDate, $endDate])
              ->orWhere(function ($q2) use ($startDate, $endDate) {
                  $q2->where('start_date', '<', $startDate)
                     ->where('end_date', '>', $endDate);
              });
        })
        ->with(['studio:id,studio_name', 'artist:id,name']) // adjust relationships
        ->latest();

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
            ->whereDate('start_date', '>', $today)
            ->with(['studio:id,studio_name', 'artist:id,name,email']);

        return $query->orderBy('start_date')->paginate($perPage);
    }

    public function getRequestsByStatus(int $studioId, string $status, int $perPage)
    {
        return SpotBooking::where('studio_id', $studioId)
            ->where('status', $status)
            ->with([
                'artist:id,name,email,avatar',
                'studio:id,studio_name'
            ])
            ->orderByDesc('start_date')
            ->paginate($perPage);
    }
}
