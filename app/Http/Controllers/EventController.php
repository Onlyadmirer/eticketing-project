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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date',
            'location' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category' => 'required|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        }

        Event::create([
            'user_id' => Auth::id(), 
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'location' => $request->location,
            'image' => $imagePath,
            'category' => $request->category,
        ]);

        $redirectRoute = Auth::user()->role === 'admin' ? 'admin.events.index' : 'organizer.events.index';

        return redirect()->route($redirectRoute)->with('success', 'Event berhasil dibuat!');
    }

    // MENAMPILKAN FORM EDIT
    public function edit(Event $event)
    {
        if (Auth::user()->role !== 'admin' && $event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('events.edit', compact('event'));
    }

    // UPDATE DATA DATABASE
    public function update(Request $request, Event $event)
    {
        if (Auth::user()->role !== 'admin' && $event->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date',
            'location' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
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
            'category' => $request->category,
        ]);

        $redirectRoute = Auth::user()->role === 'admin' ? 'admin.events.index' : 'organizer.events.index';

        return redirect()->route($redirectRoute)->with('success', 'Event berhasil diperbarui!');
    }

public function destroy(Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Anda hanya dapat menghapus acara yang Anda buat sendiri.');
        }

        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        $redirectRoute = Auth::user()->role === 'admin' ? 'admin.events.index' : 'organizer.events.index';

        return redirect()->route($redirectRoute)->with('success', 'Event berhasil dihapus!');
    }
}