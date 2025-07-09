<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TattooStyle extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function artist(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withTimestamps();
    }
}
