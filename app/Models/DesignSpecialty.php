<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DesignSpecialty extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function studios(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }


}
