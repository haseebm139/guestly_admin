<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomForm extends Model
{

    use HasFactory;

    protected $guarded = [];
    public function fields()
    {
        return $this->hasMany(CustomFormField::class)->orderBy('order', 'asc');
    }
}
