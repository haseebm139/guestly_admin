<?php
namespace App\Repositories\API;

interface SpotBookingRepositoryInterface
{
   /* CREATE */
    public function create(array $data);

    /* READ */
    public function find(int $id);
    public function allForCurrentUser(int $perPage = 10);   // artist or studio

    /* UPDATE */
    public function reschedule(int $id, array $data);
    public function approve(int $id);
    public function reject(int $id);
}
