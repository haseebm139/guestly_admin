<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFormField extends Model
{

    use HasFactory;
    protected $guarded = [];
    protected $casts = [

        'options' => 'array',

    ];

    public function form()
    {
        return $this->belongsTo(CustomForm::class);
    }


    public function customForm()
    {
        return $this->belongsTo(CustomForm::class, 'custom_form_id');
    }

    // Optional: Responses for this field
    public function responses()
    {
        return $this->hasMany(ClientBookingFormResponse::class, 'custom_form_field_id');
    }
}
