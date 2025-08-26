<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientBookingForm extends Model
{
    use HasFactory;
    protected $guarded = [];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->shared_code)) {
                do {
                    $code = Str::random(10);
                } while (self::where('shared_code', $code)->exists());

                $model->shared_code = $code;
            }
        });
    }
}
