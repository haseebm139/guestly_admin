<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
// use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function interests()
    {
        return $this->hasMany(Interest::class)->select('id','name','user_id');
    }

    public function videos()
    {
        return $this->hasMany(Gallery::class)
        ->select('id','user_id','file_path','file_type','caption')
        ->skip(0)->take(6)
        ->orderBy('created_at','DESC')
        ->where('file_type','video');
    }
    public function images()
    {
        return $this->hasMany(Gallery::class)
        ->select('id','user_id','file_path','file_type','caption')
        ->skip(0)->take(6)
        ->orderBy('created_at','DESC')
        ->where('file_type','image');
    }
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path) {
            return asset('storage/' . $this->profile_photo_path);
        }

        return $this->profile_photo_path;
    }



    /**
     * studio-specific attributes
     * The supplies provided by the studio.
     */
    public function supplies(): BelongsToMany
    {
        return $this->belongsToMany(Supply::class, 'studio_supply');
    }


    /**
     * The specific station amenities provided by the studio.
     */
    public function stationAmenitiesProvided(): BelongsToMany
    {
        // Use 'station_amenities_list' as the table name for the related model
        return $this->belongsToMany(StationAmenity::class, 'studio_station_amenity', 'studio_id', 'station_amenity_id');
    }

    public function stationAmenities()
    {
        return $this->belongsToMany(StationAmenity::class, 'studio_station_amenity');
    }

    public function studioImages()
    {
        return $this->hasMany(StudioImage::class);
    }

     public function portfolioFile()
    {
        return $this->hasMany(PortfolioFile::class);
    }

    public function tattooStyles()
    {
        return $this->belongsToMany(TattooStyle::class) ;
    }


    public function spotBookingsAsArtist() {
        return $this->hasMany(SpotBooking::class, 'artist_id');
    }

    public function spotBookingsAsStudio() {
        return $this->hasMany(SpotBooking::class, 'studio_id');
    }



    public function designSpecialties()
    {
        return $this->belongsToMany(DesignSpecialty::class);
    }

}
