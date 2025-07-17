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
}
