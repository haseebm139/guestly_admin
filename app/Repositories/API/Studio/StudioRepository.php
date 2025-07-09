<?php
namespace App\Repositories\API\Studio;

use App\Models\User;
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

        $user->update(Arr::except($data, ['supplies_provided', 'amenities','studio_images']));

        return $user->load(['supplies', 'stationAmenities','studioImages']);
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
}
