<?php

namespace App\Repositories\API\Artist;

use App\Models\SpotBooking;
use App\Models\User;
use Illuminate\Support\Arr;

class ArtistRepository implements ArtistRepositoryInterface
{
    public function updateProfile(int $userId, array $data)
    {
        $user = User::where('id', $userId)
            ->where('user_type', 'artist')
            ->firstOrFail();

        if (isset($data['tattoo_style']) && is_array($data['tattoo_style'])) {
            $user->tattooStyles()->sync($data['tattoo_style']);
        }

        // ✅ Update user fields except tattoo styles
        $user->update(Arr::except($data, ['tattoo_style']));

        // ✅ Return with relations
        return $user->load(['supplies', 'stationAmenities', 'studioImages', 'designSpecialties', 'tattooStyles']);
    }

    public function getById(int $userId)
    {
        $user = User::where('id', $userId)
            ->where('user_type', 'artist')
            ->firstOrFail();

        return $user->load(['supplies', 'stationAmenities', 'studioImages', 'designSpecialties', 'tattooStyles', 'activeSubscription.plan']);
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

    public function getAllStudios(int $perPage = 10)
    {
        return User::where('user_type', 'studio')
            ->withCount([
                'favoritedBy as is_favorite' => function ($query) use ($artistId) {
                    $query->where('artist_id', $artistId);
                },
            ])
            ->with([
                'supplies:id,name',
                'stationAmenities:id,name',
                'studioImages:id,user_id,image_path',
                'designSpecialties:id,name',
            ])
            ->paginate($perPage);
    }

    public function bookedStudios(int $perPage = 10)
    {
        $artistId = auth()->id();
        // $studio_id = SpotBooking::where('artist_id', $artistId)->pluck('studio_id');
        $studioIds = SpotBooking::where('artist_id', $artistId)
            ->where('status', 'approved')  // only approved bookings
            // ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->pluck('studio_id')
            ->unique()
            ->toArray();

        $studio_id = array_values($studioIds);

        return User::where('user_type', 'studio')->whereIn('id', $studio_id)
            ->withCount([
                'favoritedBy as is_favorite' => function ($query) use ($artistId) {
                    $query->where('artist_id', $artistId);
                },
            ])
            ->with([
                'supplies:id,name',
                'stationAmenities:id,name',
                'studioImages:id,user_id,image_path',
                'designSpecialties:id,name',
            ])->paginate($perPage);
    }

    public function findStudio(int $id)
    {
        $artistId = auth()->id();
        $longitude = auth()->user()->longitude;
        $latitude = auth()->user()->latitude;

        return User::where('user_type', 'studio')
            ->where('id', $id) // ✅ filter by studio ID
            ->withCount([
                'favoritedBy as is_favorite' => function ($q) use ($artistId) {
                    $q->where('artist_id', $artistId);
                },
            ])
            ->with([
                'supplies:id,name',
                'stationAmenities:id,name',
                'studioImages:id,user_id,image_path',
                'designSpecialties:id,name',
                'tattooStyles:id,name',
            ])
            ->selectRaw('
            (6371 * acos(
                cos(radians(?)) *
                cos(radians(latitude)) *
                cos(radians(longitude) - radians(?)) +
                sin(radians(?)) *
                sin(radians(latitude))
            )) AS distance
        ', [$latitude, $longitude, $latitude])
            ->first();
    }
}
