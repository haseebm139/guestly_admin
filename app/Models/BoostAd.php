<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoostAd extends Model
{
    use HasFactory;
    protected $guarded = [];


     protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
}
