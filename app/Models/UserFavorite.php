<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFavorite extends Model
{
    use HasFactory;

     protected $fillable = [
        'artist_id',
        'studio_id',
    ];

    public function artist()
    {
        return $this->belongsTo(\App\Models\User::class, 'artist_id');
    }

    public function studio()
    {
        return $this->belongsTo(\App\Models\User::class, 'studio_id');
    }
}
