<?php
namespace App\Services\Artist;

use App\Repositories\API\Artist\ArtistRepositoryInterface;
use App\Services\Artist\ArtistImageService;
use App\Models\User;
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

        return User::where('user_type', 'studio')
            ->with(['supplies:id,name', 'stationAmenities:id,name', 'studioImages:id,user_id,image_path'])
            ->paginate($perPage);
        // return $this->repo->getAllStudios($perPage);
    }

     public function getStudios1(int $perPage = 10)
    {
        return $this->repo->getAllStudios1($perPage);
    }

}
