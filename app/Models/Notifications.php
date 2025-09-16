<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    protected $table = 'firebase_notifications'; // Ensure this matches your migration
    protected $fillable = [
        'title',
        'description',
        'type',
        'scheduled_at',
        'user_ids',
        'status',
        'image',
        'created_by',
        'topic',
        'body',
    ];
    protected $casts = [
        'scheduled_at' => 'datetime',
        'user_ids' => 'array', // If you're storing JSON user IDs
    ];
}
