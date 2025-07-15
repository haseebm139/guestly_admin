<?php
namespace App\Repositories\Admin;

interface SupplyRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
