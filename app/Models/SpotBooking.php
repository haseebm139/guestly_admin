<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotBooking extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function artist() {
        return $this->belongsTo(User::class, 'artist_id');
    }

    public function studio() {
        return $this->belongsTo(User::class, 'studio_id');
    }
}
