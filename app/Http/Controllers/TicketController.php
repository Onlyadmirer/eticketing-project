<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    // MENAMPILKAN DAFTAR TIKET BERDASARKAN EVENT
    public function index(Event $event)
    {
        if (Auth::user()->role !== 'admin' && $event->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengelola tiket event ini.');
        }

        $tickets = $event->tickets;

        return view('tickets.index', compact('event', 'tickets'));
    }

    // FORM TAMBAH TIKET
    public function create(Event $event)
    {
        return view('tickets.create', compact('event'));
    }

    // SIMPAN TIKET KE DATABASE
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $event->tickets()->create([
            'name' => $request->name,
            'price' => $request->price,
            'quota' => $request->quota,
            'description' => $request->description,
        ]);

        $route = Auth::user()->role === 'admin' ? 'admin.events.tickets.index' : 'organizer.events.tickets.index';
        
        return redirect()->route($route, $event->id)->with('success', 'Tiket berhasil ditambahkan!');
    }

    // HAPUS TIKET
    public function destroy(Ticket $ticket)
    {
        $eventId = $ticket->event_id; 
        
        $ticket->delete();

        $route = Auth::user()->role === 'admin' ? 'admin.events.tickets.index' : 'organizer.events.tickets.index';
        
        return redirect()->route($route, $eventId)->with('success', 'Tiket berhasil dihapus.');
    }
}