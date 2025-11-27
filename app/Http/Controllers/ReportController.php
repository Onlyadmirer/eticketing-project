<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // MENAMPILKAN DAFTAR PESERTA (SEMUA STATUS)
    public function index(Event $event)
    {
        if (Auth::user()->role !== 'admin' && $event->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak melihat laporan event ini.');
        }
        $bookings = Booking::with(['user', 'ticket'])
            ->whereHas('ticket', function ($query) use ($event) {
                $query->where('event_id', $event->id);
            })
            ->latest()
            ->get();

        $totalRevenue = $bookings->where('status', 'approved')->sum('total_price');

        $totalTickets = $bookings->where('status', 'approved')->sum('quantity');

        return view('reports.index', compact('event', 'bookings', 'totalRevenue', 'totalTickets'));
    }

    // UPDATE STATUS BOOKING (APPROVE / CANCEL)
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:approved,canceled,pending',
        ]);

        $newStatus = $request->status;
        $oldStatus = $booking->status;

        if ($oldStatus === 'canceled' && $newStatus !== 'canceled') {
            if ($booking->ticket->quota < $booking->quantity) {
                return redirect()->back()->with('error', 'Sisa kuota tiket tidak cukup untuk mengaktifkan pesanan ini.');
            }
            $booking->ticket->decrement('quota', $booking->quantity);
        }

        if ($oldStatus !== 'canceled' && $newStatus === 'canceled') {
            $booking->ticket->increment('quota', $booking->quantity);
        }

        $booking->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Status pemesanan berhasil diperbarui.');
    }
}