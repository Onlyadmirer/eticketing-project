<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    // MENYIMPAN PESANAN (CHECKOUT)
    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
        ]);

        $ticket = Ticket::findOrFail($request->ticket_id);

        // 1. Cek Kuota
        if ($ticket->quota < 1) {
            return redirect()->back()->with('error', 'Maaf, tiket ini sudah habis!');
        }

        // 2. Buat Booking
        // Kita gunakan DB Transaction biar aman (opsional, tapi good practice)
        // Di sini kita pakai cara simpel dulu:

        Booking::create([
            'user_id' => Auth::id(),
            'ticket_id' => $ticket->id,
            'booking_code' => 'TIX-' . strtoupper(Str::random(10)), // Contoh: TIX-A1B2C3D4E5
            'status' => 'approved', // Kita anggap otomatis approved dulu agar tiket langsung dapat
        ]);

        // 3. Kurangi Kuota
        $ticket->decrement('quota');

        return redirect()->route('user.bookings.index')->with('success', 'Tiket berhasil dipesan!');
    }

    // MELIHAT RIWAYAT PESANAN (HISTORY)
    public function index()
    {
        // Ambil booking milik user yang sedang login
        // 'ticket.event' adalah Eager Loading biar query ringan
        $bookings = Booking::with(['ticket.event'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.bookings', compact('bookings'));
    }
}