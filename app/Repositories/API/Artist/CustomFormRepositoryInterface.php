<?php
namespace App\Repositories\API\Artist;

interface CustomFormRepositoryInterface
{
    public function create(array $data);
    public function getByArtist($artistId);
    public function getById($id);
}
