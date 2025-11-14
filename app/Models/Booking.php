<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Relasi
    
    // 1 booking dimiliki oleh 1 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 1 booking memesan 1 jenis tiket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}