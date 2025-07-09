<?php
namespace App\Repositories\API\Artist;

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
        return $user->load([
            'tattooStyles',
            'supplies', 'stationAmenities','studioImages'
        ]);
    }



    public function getById(int $userId)
    {
        $user = User::where('id', $userId)
            ->where('user_type', 'artist')
            ->firstOrFail();
        return $user->load([
            'tattooStyles',
            'supplies', 'stationAmenities','studioImages'
        ]);
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

    public function getAllStudios1(int $perPage = 10)
    {
        return User::where('user_type', 'studio')
            ->with([
                'supplies:id,name',
                'stationAmenities:id,name',
                'studioImages:id,user_id,image_path',
            ])
            ->paginate($perPage);
    }



}
