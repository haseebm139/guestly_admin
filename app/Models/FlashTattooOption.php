<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashTattooOption extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tattoo()
    {
        return $this->belongsTo(FlashTattoo::class);
    }
}
