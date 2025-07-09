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

        $user->supplies()->sync($data['supplies_provided'] ?? []);
        $user->stationAmenities()->sync($data['amenities'] ?? []);

        $user->update(Arr::except($data, ['supplies_provided', 'amenities']));

        return $user->load(['supplies', 'stationAmenities']);
    }



    public function getById(int $userId)
    {
        $user = User::with(['supplies', 'stationAmenities'])->where('id', $userId)
            ->where('user_type', 'studio')
            ->firstOrFail();

        $user->supplies_provided = json_decode($user->supplies_provided);
        $user->amenities = json_decode($user->amenities);

        return $user;
    }
}
