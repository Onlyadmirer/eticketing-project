<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'email', 'password', 'role', 'organizer_status'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOrganizer(): bool
    {
        return $this->role === 'organizer';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }


    /**
     * Cek apakah user bisa mengelola event (Admin atau Organizer Approved)
     */
    public function canManageEvents(): bool
    {
        // User adalah admin ATAU (dia adalah organizer DAN statusnya approved)
        return $this->isAdmin() || ($this->isOrganizer() && $this->organizer_status === 'approved');
    }

    // Relasi

    // 1 user (organizer) bisa punya banyak event
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    // 1 user bisa punya banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // 1 user bisa punya banyak event favorit
    public function favorites()
    {
        return $this->belongsToMany(Event::class, 'favorites');
    }
}