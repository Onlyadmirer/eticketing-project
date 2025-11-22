<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    // Halaman Depan (Homepage)
    public function index(Request $request)
    {
        // Ambil input pencarian (jika ada)
        $search = $request->input('search');

        // Query Event: Urutkan terbaru, filter jika ada search
        $events = Event::query()
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")->orWhere('location', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('welcome', compact('events'));
    }

    // Halaman Detail Event
    public function show($id)
    {
        // Ambil event beserta tiketnya dan data organizer
        $event = Event::with(['tickets', 'organizer'])->findOrFail($id);

        return view('event_detail', compact('event'));
    }
}