<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'event_time',
        'location',
        'image_path',
    ];

    // Relasi

    // 1 event dimiliki oleh 1 user (organizer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 1 event bisa punya banyak jenis tiket
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}