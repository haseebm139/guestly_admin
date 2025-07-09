<?php
namespace App\Repositories\API\Artist;

interface ArtistRepositoryInterface
{
    public function updateProfile(int $userId,array $data);
    public function getById(int $userId);

    public function saveGalleryImages(int $userId, array $paths);
    public function getAllStudios1(int $perPage = 10);

}

