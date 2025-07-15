<?php
namespace App\Repositories\API\Studio;

interface StudioRepositoryInterface
{
    public function updateProfile(int $userId,array $data);
    public function getById(int $userId);

    public function saveGalleryImages(int $userId, array $paths);
    public function getGuests(int $userId, string $range, int $perPage);
    // public function getActiveBoostAd(int $studioId, int $perPage);
    public function getUpcomingGuests(int $studioId, int $perPage);
    public function getRequestsByStatus(int $studioId, string $status, int $perPage);


}

