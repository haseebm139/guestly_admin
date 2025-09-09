<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'sender_role',
        'receiver_role',
        'type',
        'title',
        'body',
        'studio_name',
        'artist_name',
        'url',
        'token',
        'data',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        // 'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];
}
