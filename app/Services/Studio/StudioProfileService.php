<?php
namespace App\Services\Studio;

use App\Repositories\API\Studio\StudioRepositoryInterface;
use App\Services\Studio\StudioImageService;
use App\Models\User;
class StudioProfileService
{
    protected $repo;
    protected $imageService;

    public function __construct(StudioRepositoryInterface  $repo,
    StudioImageService $imageService)
    {
        $this->repo = $repo;
         $this->imageService = $imageService;
    }

    public function updateProfile(int $userId, array $data)
    {

        if (isset($data['studio_logo'])) {
            $data['studio_logo'] = $this->imageService->uploadImage($data['studio_logo'], 'logo', 'logos');
        }

        if (isset($data['studio_cover'])) {
            $data['studio_cover'] = $this->imageService->uploadImage($data['studio_cover'], 'cover', 'covers');
        }
        if (isset($data['avatar'])) {
            $data['avatar'] = $this->imageService->uploadImage($data['avatar'], 'avatar', 'avatar');
        }
        if (isset($data['studio_images']) && is_array($data['studio_images'])) {
            $galleryPaths = $this->imageService->uploadGalleryImages($data['studio_images']);
            $this->repo->saveGalleryImages($userId, $galleryPaths);
        }
        if (isset($data['guest_policy']) ) {

            $data['guest_policy'] = $this->imageService->uploadImage($data['guest_policy'], 'guest_policy', 'guest_policy');
        }

        return $this->repo->updateProfile($userId, $data);
    }


    public function getProfile(int $userId)
    {

        return $this->repo->getById($userId);
    }

    public function getGuests(int $studioId, string $range, int $perPage)
    {
        return $this->repo->getGuests($studioId, $range, $perPage);
    }

    public function getUpcomingGuests(int $studioId, int $perPage = 20)
    {
        return $this->repo->getUpcomingGuests($studioId, $perPage);
    }

    public function getGuestRequests(int $studioId, string $status, int $perPage)
    {
        return $this->repo->getRequestsByStatus($studioId, $status, $perPage);
    }

    public function getArtist($filters)
    {
        $query = User::query()->where('user_type', 'artist')->with('tattooStyles');
        if (!empty($filters['search'])) {
        $query->where(function($q) use ($filters) {
            $q->where('name', 'like', "%{$filters['search']}%")
              ->orWhere('last_name', 'like', "%{$filters['search']}%")
              ->orWhere('email', 'like', "%{$filters['search']}%")
              ->orWhereHas('tattooStyles', function ($styleQuery) use ($search) {
                  $styleQuery->where('name', 'like', "%{$search}%");
              });
            });
        }
        if (!empty($filters['name'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['name']}%")
                ->orWhere('last_name', 'like', "%{$filters['name']}%");
            });
        }

        if (!empty($filters['email'])) {
            $query->where('email', 'like', "%{$filters['email']}%") ;
        }

        // 🔹 Filter by city
        if (!empty($filters['city'])) {
            $query->where('city', 'like', "%{$filters['city']}%");
        }

        // 🔹 Filter by country
        if (!empty($filters['country'])) {
            $query->where('country', 'like', "%{$filters['country']}%");
        }

        // 🔹 Filter by language
        if (!empty($filters['language'])) {
            $query->where('language', 'like', "%{$filters['language']}%");
        }

        // 🔹 Filter by Tattoo Style (exact match if dropdown filter)
        if (!empty($filters['tattoo_style'])) {
            $query->whereHas('tattooStyles', function ($styleQuery) use ($filters) {
                $styleQuery->where('name', $filters['tattoo_style']);
            });
        }

        // // 🔹 Radius Search (if lat + lng + radius are given)
        // if (!empty($filters['latitude']) && !empty($filters['longitude']) && !empty($filters['radius'])) {
        //     $lat = $filters['latitude'];
        //     $lng = $filters['longitude'];
        //     $radius = $filters['radius']; // in kilometers

        //     $query->selectRaw("users.*, (
        //             6371 * acos(
        //                 cos(radians(?)) * cos(radians(latitude)) *
        //                 cos(radians(longitude) - radians(?)) +
        //                 sin(radians(?)) * sin(radians(latitude))
        //             )
        //         ) AS distance", [$lat, $lng, $lat])
        //         ->having('distance', '<=', $radius)
        //         ->orderBy('distance');
        // }
        // 🔹 Pagination
        $perPage = $filters['per_page'] ?? 15;
        return $query->paginate($perPage);
    }

}
