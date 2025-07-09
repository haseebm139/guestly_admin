<?php
namespace App\Repositories\API;
use App\Models\Card;

interface CardRepositoryInterface
{
    public function all($userId);
    public function find($id, $userId);
    public function store(array $data);
    public function update($id, array $data, $userId);
    public function delete($id, $userId);
}
