<?php
namespace App\Services\Artist;

use App\Repositories\API\Artist\ArtistRepositoryInterface;
use App\Services\Artist\ArtistImageService;
use App\Models\User;
use App\Models\UserFavorite;
class ArtistProfileService
{
    protected $repo;
    protected $imageService;

    public function __construct(ArtistRepositoryInterface  $repo,
    ArtistImageService $imageService)
    {
        $this->repo = $repo;
         $this->imageService = $imageService;
    }

    public function updateProfile(int $userId, array $data)
    {

        // if (isset($data['studio_logo'])) {
        //     $data['studio_logo'] = $this->imageService->uploadImage($data['studio_logo'], 'logo', 'logos');
        // }

        // if (isset($data['studio_cover'])) {
        //     $data['studio_cover'] = $this->imageService->uploadImage($data['studio_cover'], 'cover', 'covers');
        // }

        // if (isset($data['studio_images']) && is_array($data['studio_images'])) {
        //     $galleryPaths = $this->imageService->uploadGalleryImages($data['studio_images']);
        //     $this->repo->saveGalleryImages($userId, $galleryPaths);
        // }

        return $this->repo->updateProfile($userId, $data);
    }


    public function getProfile(int $userId)
    {

        return $this->repo->getById($userId);
    }

    public function getStudios(int $perPage = 10)
    {
        $artistId = auth()->id();
        return User::where('user_type', 'studio')
             ->withCount([
                'favoritedBy as is_favorite' => function ($query) use ($artistId) {
                    $query->where('artist_id', $artistId);
                }
            ])
            ->with(['supplies:id,name', 'stationAmenities:id,name', 'studioImages:id,user_id,image_path'])
            ->paginate($perPage);
        // return $this->repo->getAllStudios($perPage);
    }

    // public function getStudios(int $perPage = 10)
    // {
    //      $artistId  = auth()->id();
    // $longitude = auth()->user()->longitude;
    // $latitude  = auth()->user()->latitude;

    // // Normal vs Boost radius
    // $normalRadius = 20;  // km
    // $boostRadius  = 100; // km

    // $query = User::where('user_type', 'studio')
    //     ->withCount([
    //         'favoritedBy as is_favorite' => function ($query) use ($artistId) {
    //             $query->where('artist_id', $artistId);
    //         }
    //     ])
    //     ->with([
    //         'supplies:id,name',
    //         'stationAmenities:id,name',
    //         'studioImages:id,user_id,image_path',
    //         'designSpecialties:id,name'
    //     ]);

    // if ($latitude && $longitude) {
    //     $query->select('users.*')
    //         ->selectRaw("
    //             (6371 * acos(
    //                 cos(radians(?)) *
    //                 cos(radians(latitude)) *
    //                 cos(radians(longitude) - radians(?)) +
    //                 sin(radians(?)) *
    //                 sin(radians(latitude))
    //             )) AS distance
    //         ", [$latitude, $longitude, $latitude]);

    //     // Hybrid radius filter
    //     $query->where(function ($q) use ($normalRadius, $boostRadius, $latitude, $longitude) {
    //         $q->whereHas('boostAds', function ($sub) use ($boostRadius) {
    //             $sub->where('status', 'completed')
    //                 ->where('start_date', '<=', now())
    //                 ->where('end_date', '>=', now());
    //         })
    //         ->orWhereRaw("
    //             (6371 * acos(
    //                 cos(radians(?)) *
    //                 cos(radians(latitude)) *
    //                 cos(radians(longitude) - radians(?)) +
    //                 sin(radians(?)) *
    //                 sin(radians(latitude))
    //             )) <= ?
    //         ", [$latitude, $longitude, $latitude, $normalRadius]);
    //     });
    // // }

    // // Order boosted first, then nearest distance
    // $query->orderByRaw('CASE WHEN EXISTS (
    //         SELECT 1 FROM boost_ads
    //         WHERE boost_ads.user_id = users.id
    //           AND boost_ads.status = "completed"
    //           AND boost_ads.start_date <= NOW()
    //           AND boost_ads.end_date >= NOW()
    //     ) THEN 0 ELSE 1 END')
    //     ->orderBy('distance', 'asc');

    //     return $query->paginate($perPage);
    // }

    public function getStudios1(int $perPage = 10)
    {
        $artistId = auth()->id();
        $longitude = auth()->user()->longitude;
        $latitude = auth()->user()->latitude;
        $radius = null; // Optional: Default radius in kilometers
        $query = User::where('user_type', 'studio')
            ->withCount([
                'favoritedBy as is_favorite' => function ($query) use ($artistId) {
                    $query->where('artist_id', $artistId);
                }
            ])
            ->with(['supplies:id,name', 'stationAmenities:id,name', 'studioImages:id,user_id,image_path','designSpecialties:id,name']);

        // If latitude & longitude are provided, calculate distance
        if ($latitude && $longitude) {
            $query->select('*')
                ->selectRaw("
                    (6371 * acos(
                        cos(radians(?)) *
                        cos(radians(latitude)) *
                        cos(radians(longitude) - radians(?)) +
                        sin(radians(?)) *
                        sin(radians(latitude))
                    )) AS distance
                ", [$latitude, $longitude, $latitude])
                ->orderBy('distance', 'asc');

            // Optional: Filter by radius if provided
            if ($radius) {
                $query->having('distance', '<=', $radius);
            }
        }

        return $query->paginate($perPage);
    }

    public function bookedStudios(int $perPage = 10)
    {

        return $this->repo->bookedStudios($perPage);

    }
    public function getStudio(int $id)
    {

        return $this->repo->findStudio($id);
    }


    public function toggle(int $artistId, int $studioId): array
    {
        // Ensure studio is actually a studio
        if (!User::where('id', $studioId)->where('user_type', 'studio')->exists()) {
            return [
                'status' => false,
                'message' => 'Invalid studio',
            ];
        }

        $favorite = UserFavorite::where('artist_id', $artistId)
            ->where('studio_id', $studioId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return [
                'status' => true,
                'message' => 'Favorite removed',
            ];
        }

        UserFavorite::create([
            'artist_id' => $artistId,
            'studio_id' => $studioId,
        ]);

        return [
            'status' => true,
            'message' => 'Studio added to favorites',
        ];
    }

}
