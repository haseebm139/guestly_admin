<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockStation extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Relation: Block belongs to a Studio (User with type=studio)
     */
    public function studio()
    {
        return $this->belongsTo(User::class, 'studio_id');
    }
}
