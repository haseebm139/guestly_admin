<?php
namespace App\Repositories\API\Artist;

interface ArtistRepositoryInterface
{
    public function updateProfile(int $userId,array $data);
    public function getById(int $userId);

    public function saveGalleryImages(int $userId, array $paths);
    public function getAllStudios(int $perPage = 10);
    public function findStudio(int $id);

}

