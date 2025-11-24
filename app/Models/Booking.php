<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket_id',
        'booking_code',
        'status',
        'quantity', 
        'total_price',
    ];

    // Relasi: Booking milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Booking memuat satu jenis Tiket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}