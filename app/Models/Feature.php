<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $guarded = [];

     public function plans()
    {
        return $this->belongsToMany(Plan::class, 'feature_plan');
    }

    public function userFeatures()
    {
        return $this->hasMany(UserFeature::class);
    }
}
