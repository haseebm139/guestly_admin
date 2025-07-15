<?php
namespace App\Services\Admin;

use App\Repositories\Admin\SupplyRepositoryInterface;

class SupplyService
{
    public function __construct(private SupplyRepositoryInterface $repo) {}

    public function all()            { return $this->repo->all(); }
    public function store($d)        { return $this->repo->create($d); }
    public function update($id,$d)   { return $this->repo->update($id,$d); }
    public function delete($id)      { return $this->repo->delete($id); }
}
