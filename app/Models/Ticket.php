<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'description',
        'price',
        'quota',
    ];

    // Relasi: Tiket milik Event tertentu
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relasi: Tiket bisa ada di banyak Booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}