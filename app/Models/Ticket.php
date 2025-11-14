<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'event_id',
        'name',
        'description',
        'price',
        'quantity',
    ];

    // Relasi
    
    // 1 jenis tiket milik 1 event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // 1 jenis tiket bisa ada di banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}