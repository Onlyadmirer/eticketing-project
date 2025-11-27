<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'event_id'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}