<?php

use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\WelcomeController;
use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/event/{id}', [WelcomeController::class, 'show'])->name('event.detail');

Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'organizer') {
        return redirect()->route('organizer.dashboard');
    } else {
        return redirect()->route('user.bookings.index');
    }
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// --- GROUP ADMIN ---
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard Admin dengan Statistik
        Route::get('/dashboard', function () {
            // Hitung Total User Biasa
            $totalUsers = User::where('role', 'user')->count();

            // Hitung Total Organizer
            $totalOrganizers = User::where('role', 'organizer')->count();

            // Hitung Total Event di Sistem
            $totalEvents = Event::count();

            // Hitung Pending Organizer (Yang butuh persetujuan)
            $pendingOrganizers = User::where('role', 'organizer')->where('organizer_status', 'pending')->count();

            // Hitung Total Pendapatan Seluruh Sistem
            $totalRevenue = Booking::where('status', 'approved')->join('tickets', 'bookings.ticket_id', '=', 'tickets.id')->sum('total_price');

            $organizerStats = User::where('role', 'organizer')
                ->with([
                    'events.tickets.bookings' => function ($query) {
                        $query->where('status', 'approved');
                    },
                ])
                ->get()
                ->map(function ($organizer) {
                    $sold = 0;
                    $earnings = 0;

                    foreach ($organizer->events as $event) {
                        foreach ($event->tickets as $ticket) {
                            $bookings = $ticket->bookings;

                            $sold += $bookings->sum('quantity');
                            $earnings += $bookings->sum('total_price');
                        }
                    }

                    return (object) [
                        'name' => $organizer->name,
                        'email' => $organizer->email,
                        'events_count' => $organizer->events->count(),
                        'total_sold' => $sold,
                        'total_revenue' => $earnings,
                    ];
                })
                ->sortByDesc('total_revenue');

            return view('admin.dashboard', compact('totalUsers', 'totalOrganizers', 'totalEvents', 'pendingOrganizers', 'totalRevenue', 'organizerStats'));
        })->name('dashboard');

        // Manage Users Route
        Route::get('/users', [ManageUserController::class, 'index'])->name('users.index');
        Route::patch('/users/{id}/verify', [ManageUserController::class, 'verifyOrganizer'])->name('users.verify');
        Route::delete('/users/{id}', [ManageUserController::class, 'destroy'])->name('users.destroy');
        Route::resource('events', EventController::class);
        // Route Manajemen Tiket (Custom)
        Route::get('/events/{event}/tickets', [TicketController::class, 'index'])->name('events.tickets.index');
        Route::get('/events/{event}/tickets/create', [TicketController::class, 'create'])->name('events.tickets.create');
        Route::post('/events/{event}/tickets', [TicketController::class, 'store'])->name('events.tickets.store');
        Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');

        // Route Report
        Route::get('/events/{event}/bookings', [ReportController::class, 'index'])->name('events.bookings');
    });

// --- GROUP ORGANIZER ---
Route::middleware(['auth', 'role:organizer'])
    ->prefix('organizer')
    ->name('organizer.')
    ->group(function () {
        Route::get('/dashboard', function () {
            $userId = Auth::id();

            // 1. Hitung Total Event
            $eventsCount = Event::where('user_id', $userId)->count();

            // 2. Hitung Total Tiket Terjual (Approved)
            $ticketsSold = Booking::whereHas('ticket.event', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
                ->where('status', 'approved')
                ->sum('quantity');

            // 3. Hitung Total Pendapatan
            $revenue = Booking::whereHas('ticket.event', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
                ->where('status', 'approved')
                ->with('ticket')
                ->get()
                ->sum('total_price');

            return view('organizer.dashboard', compact('eventsCount', 'ticketsSold', 'revenue'));
        })->name('dashboard');

        Route::resource('events', EventController::class);
        // Route Manajemen Tiket (Custom)
        Route::get('/events/{event}/tickets', [TicketController::class, 'index'])->name('events.tickets.index');
        Route::get('/events/{event}/tickets/create', [TicketController::class, 'create'])->name('events.tickets.create');
        Route::post('/events/{event}/tickets', [TicketController::class, 'store'])->name('events.tickets.store');
        Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');

        // Route Report
        Route::get('/events/{event}/bookings', [App\Http\Controllers\ReportController::class, 'index'])->name('events.bookings');
    });

// --- GROUP USER (REGISTERED) ---
Route::middleware(['auth', 'role:user'])
    ->name('user.')
    ->group(function () {
        // Route Booking
        Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::post('/booking', [BookingController::class, 'store'])->name('bookings.store');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';