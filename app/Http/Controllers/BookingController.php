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
            'quantity' => 'required|integer|min:1',
        ]);

        $ticket = Ticket::findOrFail($request->ticket_id);

        // 1. Cek Kuota
        if ($ticket->quota < $request->quantity) {
            return redirect()->back()->with('error', 'Maaf, sisa kuota tidak cukup untuk jumlah yang Anda minta.');
        }

        $totalPrice = $ticket->price * $request->quantity;

        Booking::create([
            'user_id' => Auth::id(),
            'ticket_id' => $ticket->id,
            'booking_code' => 'TIX-' . strtoupper(Str::random(10)),
            'status' => 'approved',
            'quantity' => $request->quantity,
            'total_price' => $totalPrice, 
        ]);

        $ticket->decrement('quota', $request->quantity);

        return redirect()->route('user.bookings.index')->with('success', 'Tiket berhasil dipesan!');
    }

    // MELIHAT RIWAYAT PESANAN (HISTORY)
    public function index()
    {
        $bookings = Booking::with(['ticket.event'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.bookings', compact('bookings'));
    }
}