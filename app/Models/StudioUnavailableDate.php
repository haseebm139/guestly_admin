<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudioUnavailableDate extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
    ];
    public function studio()
    {
        return $this->belongsTo(User::class, 'studio_id');
    }
}
