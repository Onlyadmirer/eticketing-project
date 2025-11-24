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
        // 1. Cek Otoritas (Security)
        // Admin boleh lihat semua, Organizer cuma boleh lihat event miliknya
        if (Auth::user()->role !== 'admin' && $event->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak melihat laporan event ini.');
        }

        // 2. Ambil Data Booking
        // Logika: Cari Booking yang Ticket-nya termasuk dalam Event ini
        $bookings = Booking::with(['user', 'ticket'])
            ->whereHas('ticket', function ($query) use ($event) {
                $query->where('event_id', $event->id);
            })
            ->latest()
            ->get();

        return view('reports.index', compact('event', 'bookings'));
    }
}