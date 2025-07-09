<?php
namespace App\Services\Studio;

use App\Repositories\API\Studio\StudioRepositoryInterface;
use App\Services\Studio\StudioImageService;

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

        if (isset($data['studio_images']) && is_array($data['studio_images'])) {
            $galleryPaths = $this->imageService->uploadGalleryImages($data['studio_images']);
            $this->repo->saveGalleryImages($userId, $galleryPaths);
        }

        return $this->repo->updateProfile($userId, $data);
    }


    public function getProfile(int $userId)
    {

        return $this->repo->getById($userId);
    }

}
