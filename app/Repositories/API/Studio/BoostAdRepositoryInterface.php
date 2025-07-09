<?php
namespace App\Repositories\API\Studio;

interface BoostAdRepositoryInterface
{
    public function create(array $data);
    public function getByStudio($studioId);
    public function stop($id, $studioId);
    public function boostAgain($id, $studioId);
}

