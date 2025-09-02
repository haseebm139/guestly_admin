<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class CustomForm extends Model
{

    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($form) {
            if (empty($form->share_token)) {
                do {
                    $token = Str::random(8); // ✅ secure random string
                } while (static::where('share_token', $token)->exists());

                $form->share_token = $token;
            }
        });
    }
    public function fields()
    {
        return $this->hasMany(CustomFormField::class)->orderBy('order', 'asc');
    }

    public function artist()
    {
        return $this->belongsTo(User::class, 'artist_id');
    }

    public function bookings()
    {
        return $this->hasMany(ClientBookingForm::class, 'custom_form_id');
    }

    public function clientBookingForms()
    {
        return $this->hasMany(ClientBookingForm::class, 'custom_form_id');
    }
}
