<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudioWeeklyAvailability extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function studio()
    {
        return $this->belongsTo(User::class, 'studio_id');
    }
}
