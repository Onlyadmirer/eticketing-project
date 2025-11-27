<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // DAFTAR FAVORIT SAYA
    public function index()
    {
        $favorites = Favorite::with('event')->where('user_id', Auth::id())->latest()->get();

        return view('user.favorites', compact('favorites'));
    }

    // TOGGLE FAVORITE (Simpan / Hapus)
    public function toggle(Event $event)
    {
        $user = Auth::user();

        $existing = Favorite::where('user_id', $user->id)->where('event_id', $event->id)->first();

        if ($existing) {
            $existing->delete();
            $message = 'Dihapus dari favorit.';
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
            ]);
            $message = 'Ditambahkan ke favorit!';
        }

        return redirect()->back()->with('success', $message);
    }
}