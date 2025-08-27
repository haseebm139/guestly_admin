<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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
                    $code = Str::random(8).auth()->id().Str::random(8);
                } while (self::where('shared_code', $code)->exists());

                $model->shared_code = $code;
            }
        });
    }

    public function studio()
    {
        return $this->belongsTo(User::class, 'studio_id');
    }
    public function customForm()
    {
        return $this->belongsTo(CustomForm::class, 'custom_form_id');
    }

    // Relation: Access the fields of the custom form
    public function customFormFields()
    {
        return $this->customForm()->with('fields');
    }

    // Relation: Responses submitted by the client
    public function responses()
    {
        return $this->hasMany(ClientBookingFormResponse::class, 'client_booking_form_id');
    }

}
