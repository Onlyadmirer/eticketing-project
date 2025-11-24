<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // MENAMPILKAN DAFTAR PESERTA PER EVENT
    public function index(Event $event)
    {
        // Cek Otoritas (Security)
        if (Auth::user()->role !== 'admin' && $event->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak melihat laporan event ini.');
        }

        // Ambil Booking yang Approved
        $bookings = Booking::with(['user', 'ticket'])
            ->whereHas('ticket', function ($query) use ($event) {
                $query->where('event_id', $event->id);
            })
            ->where('status', 'approved') 
            ->latest()
            ->get();

        // Hitung Total Pendapatan
        $totalRevenue = $bookings->sum(function ($booking) {
            return $booking->total_price;
        });

        // Hitung Total Tiket (Quantity)
        $totalTickets = $bookings->sum('quantity');

        return view('reports.index', compact('event', 'bookings', 'totalRevenue', 'totalTickets'));
    }
}