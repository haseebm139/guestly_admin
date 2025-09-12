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
        $query = User::query()->where('user_type', 'artist');
        if (!empty($filters['search'])) {
        $query->where(function($q) use ($filters) {
            $q->where('name', 'like', "%{$filters['search']}%")
              ->orWhere('last_name', 'like', "%{$filters['search']}%")
              ->orWhere('email', 'like', "%{$filters['search']}%");
        });
    }
        // 🔹 Pagination
        $perPage = $filters['per_page'] ?? 15;
        return $query->paginate($perPage);
    }

}
