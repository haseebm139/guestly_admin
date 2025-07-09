<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Supply extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * The studios that provide this supply.
     */
    public function studios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'studio_supply');
    }


}
