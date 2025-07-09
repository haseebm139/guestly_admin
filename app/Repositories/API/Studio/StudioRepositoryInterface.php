<?php
namespace App\Repositories\API\Studio;

interface StudioRepositoryInterface
{
    public function updateProfile(int $userId,array $data);
    public function getById(int $userId);

    public function saveGalleryImages(int $userId, array $paths);
}

