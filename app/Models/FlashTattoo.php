<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashTattoo extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function artist()
    {
        return $this->belongsTo(User::class, 'artist_id');
    }

    public function options()
    {
        return $this->hasMany(FlashTattooOption::class);
    }


}
