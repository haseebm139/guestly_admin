<?php
namespace App\Repositories\Admin;

use App\Models\Supply;

class SupplyRepository implements SupplyRepositoryInterface
{
    public function all()                 { return Supply::latest()->get(); }
    public function create(array $d)      { return Supply::create($d); }
    public function update($id, $d)       { return tap(Supply::findOrFail($id))->update($d); }
    public function delete($id)           { return Supply::destroy($id); }
}
