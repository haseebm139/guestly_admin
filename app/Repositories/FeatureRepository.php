<?php

namespace App\Repositories;

use App\Models\Feature;
use Illuminate\Support\Str;
use App\Interfaces\FeatureRepositoryInterface;
class FeatureRepository implements FeatureRepositoryInterface
{
    public function all()
    {
        return Feature::all();
    }

    public function find($id)
    {
        return Feature::find($id);
    }

    public function create(array $data)
    {
        $code = Str::slug($data['name'], '_');

        if (Feature::where('code', $code)->exists()) {
            throw new \Exception('A feature with similar name/code already exists.');
        }

        $data['code'] = $code;

        return Feature::create($data);
    }

    public function update($id, array $data)
    {
        $feature = Feature::findOrFail($id);
        $code = Str::slug($data['name'], '_');

        $exists = Feature::where('code', $code)->where('id', '!=', $id)->exists();
        if ($exists) {
            throw new \Exception('A feature with similar name/code already exists.');
        }

        $data['code'] = $code;

        return $feature->update($data);
    }

    public function delete($id)
    {
        return Feature::findOrFail($id)->delete();
    }


    public function changeStatus($id, $status)
    {
        return Feature::where('id', $id)->update(['status' => $status]);
    }
}
