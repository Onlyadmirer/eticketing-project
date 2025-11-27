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

        $ticket = Ticket::with('event')->findOrFail($request->ticket_id);

        if (now()->greaterThan(\Carbon\Carbon::parse($ticket->event->start_time))) {
            return redirect()->back()->with('error', 'Maaf, event ini sudah selesai. Pembelian ditutup.');
        }

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

    // MEMBATALKAN PESANAN
    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->status === 'canceled') {
            return redirect()->back()->with('error', 'Pesanan ini sudah dibatalkan sebelumnya.');
        }

        $eventTime = \Carbon\Carbon::parse($booking->ticket->event->start_time);
        if (now()->greaterThanOrEqualTo($eventTime)) {
            return redirect()->back()->with('error', 'Maaf, event sudah dimulai/selesai. Tidak bisa membatalkan tiket.');
        }

        $booking->update(['status' => 'canceled']);

        $booking->ticket->increment('quota', $booking->quantity);

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan dan dana akan dikembalikan (Simulasi).');
    }

    // MENAMPILKAN E-TICKET (DIGITAL TICKET)
    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Ini bukan tiket Anda.');
        }

        if ($booking->status !== 'approved') {
            return redirect()->back()->with('error', 'Tiket belum disetujui atau dibatalkan.');
        }

        return view('user.ticket', compact('booking'));
    }
}