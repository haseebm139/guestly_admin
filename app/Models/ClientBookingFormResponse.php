<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientBookingFormResponse extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function bookingForm()
    {
        return $this->belongsTo(ClientBookingForm::class, 'client_booking_form_id');
    }

    public function field()
    {
        return $this->belongsTo(CustomFormField::class, 'custom_form_field_id');
    }
}
