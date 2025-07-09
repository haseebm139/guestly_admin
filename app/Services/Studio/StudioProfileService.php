<?php
namespace App\Services\Studio;

use App\Repositories\API\Studio\StudioRepositoryInterface;

class StudioProfileService
{
    protected $repo;

    public function __construct(StudioRepositoryInterface  $repo)
    {
        $this->repo = $repo;
    }

    public function updateProfile(int $userId, array $data)
    {

        return $this->repo->updateProfile($userId, $data);
    }

    public function getProfile(int $userId)
    {

        return $this->repo->getById($userId);
    }
}
