<?php
namespace App\Services\SpotBooking;

use App\Repositories\API\SpotBookingRepositoryInterface;

class SpotBookingService
{
    public function __construct(protected SpotBookingRepositoryInterface $repo) {}

    public function create(array $data)            { return $repo->create($data); }
    public function paginate(int $perPage = 10)    { return $repo->allForCurrentUser($perPage); }
    public function find(int $id)                  { return $repo->find($id); }
    public function reschedule(int $id, array $d)  { return $repo->reschedule($id, $d); }
    public function approve(int $id)               { return $repo->approve($id); }
    public function reject(int $id)                { return $repo->reject($id); }
}
