<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StationAmenity extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'icon'];
    public function studios(): BelongsToMany
    {
        return $this->belongsToMany(Studio::class, 'studio_station_amenity');
    }
}
