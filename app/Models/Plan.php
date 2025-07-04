<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function features()
    {
        return $this->belongsToMany(Feature::class, 'feature_plan');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
