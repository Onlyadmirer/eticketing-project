<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description', 'category', 'start_time', 'location', 'image'];

    // Relasi: Event dimiliki oleh satu User (Organizer)    
    public function organizer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi: Event punya banyak jenis Tiket
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    // Relasi ke Favorites
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Helper: Cek apakah user sedang login memfavoritkan event ini
    public function isFavoritedBy($user)
    {
        if (!$user) {
            return false;
        }
        return $this->favorites->where('user_id', $user->id)->count() > 0;
    }
}