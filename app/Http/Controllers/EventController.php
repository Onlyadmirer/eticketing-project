<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // MENAMPILKAN DAFTAR EVENT
    public function index()
    {
        $user = Auth::user();

        // Logika: Admin lihat semua, Organizer cuma lihat punya sendiri
        if ($user->role === 'admin') {
            $events = Event::latest()->get();
        } else {
            $events = Event::where('user_id', $user->id)->latest()->get();
        }

        return view('events.index', compact('events'));
    }

    // MENAMPILKAN FORM CREATE
    public function create()
    {
        return view('events.create');
    }

    // MENYIMPAN DATA KE DATABASE
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date',
            'location' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        // 2. Handle Upload Gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Simpan ke folder 'events' di dalam storage public
            $imagePath = $request->file('image')->store('events', 'public');
        }

        // 3. Simpan ke Database
        Event::create([
            'user_id' => Auth::id(), // Organizer yang sedang login
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'location' => $request->location,
            'image' => $imagePath,
        ]);

        $redirectRoute = Auth::user()->role === 'admin' ? 'admin.events.index' : 'organizer.events.index';

        return redirect()->route($redirectRoute)->with('success', 'Event berhasil dibuat!');
    }

    // MENAMPILKAN FORM EDIT
    public function edit(Event $event)
    {
        // Proteksi: Organizer A tidak boleh edit event Organizer B
        if (Auth::user()->role !== 'admin' && $event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('events.edit', compact('event'));
    }

    // UPDATE DATA DATABASE
    public function update(Request $request, Event $event)
    {
        // Proteksi
        if (Auth::user()->role !== 'admin' && $event->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date',
            'location' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle Update Gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $event->image = $request->file('image')->store('events', 'public');
        }

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'location' => $request->location,
            // Jika ada gambar baru, update. Jika tidak, pakai yang lama ($event->image sudah dihandle di atas)
        ]);

        $redirectRoute = Auth::user()->role === 'admin' ? 'admin.events.index' : 'organizer.events.index';

        return redirect()->route($redirectRoute)->with('success', 'Event berhasil diperbarui!');
    }

    // MENGHAPUS EVENT
    public function destroy(Event $event)
    {
        if (Auth::user()->role !== 'admin' && $event->user_id !== Auth::id()) {
            abort(403);
        }

        // Hapus gambar dari storage
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        $redirectRoute = Auth::user()->role === 'admin' ? 'admin.events.index' : 'organizer.events.index';

        return redirect()->route($redirectRoute)->with('success', 'Event berhasil dihapus!');
    }
}