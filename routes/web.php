<?php

use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Organizer\StatusController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\WelcomeController;
use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureOrganizerApproved;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/events', [WelcomeController::class, 'browse'])->name('events.browse');
Route::get('/event/{id}', [WelcomeController::class, 'show'])->name('event.detail');

Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'organizer') {
        if ($user->organizer_status === 'approved') {
            return redirect()->route('organizer.dashboard');
        } else {
            return redirect()->route('organizer.status');
        }
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
        Route::get('/dashboard', function () {
            $totalUsers = User::where('role', 'user')->count();
            $totalOrganizers = User::where('role', 'organizer')->count();
            $totalEvents = Event::count();
            $pendingOrganizers = User::where('role', 'organizer')->where('organizer_status', 'pending')->count();
            $totalRevenue = Booking::where('status', 'approved')->sum('total_price');

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
                            $sold += $ticket->bookings->sum('quantity');
                            $earnings += $ticket->bookings->sum('total_price');
                        }
                    }
                    return (object) ['name' => $organizer->name, 'email' => $organizer->email, 'events_count' => $organizer->events->count(), 'total_sold' => $sold, 'total_revenue' => $earnings];
                })
                ->sortByDesc('total_revenue');

            $recentBookings = Booking::with(['user', 'ticket.event'])
                ->where('status', 'approved')
                ->latest()
                ->take(5)
                ->get();

            return view('admin.dashboard', compact('totalUsers', 'totalOrganizers', 'totalEvents', 'pendingOrganizers', 'totalRevenue', 'organizerStats', 'recentBookings'));
        })->name('dashboard');

        Route::get('/users', [ManageUserController::class, 'index'])->name('users.index');
        Route::patch('/users/{id}/verify', [ManageUserController::class, 'verifyOrganizer'])->name('users.verify');
        Route::delete('/users/{id}', [ManageUserController::class, 'destroy'])->name('users.destroy');
        Route::resource('events', EventController::class);
        Route::get('/events/{event}/tickets', [TicketController::class, 'index'])->name('events.tickets.index');
        Route::get('/events/{event}/tickets/create', [TicketController::class, 'create'])->name('events.tickets.create');
        Route::post('/events/{event}/tickets', [TicketController::class, 'store'])->name('events.tickets.store');
        Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');

        Route::get('/events/{event}/bookings', [ReportController::class, 'index'])->name('events.bookings');
        Route::patch('/bookings/{booking}/status', [ReportController::class, 'updateStatus'])->name('bookings.updateStatus');
    });

// --- GROUP ORGANIZER ---
Route::middleware(['auth', 'role:organizer'])
    ->prefix('organizer')
    ->name('organizer.')
    ->group(function () {
        Route::get('/status', [StatusController::class, 'index'])->name('status');
        Route::delete('/account', [StatusController::class, 'destroy'])->name('account.delete');

        Route::middleware([EnsureOrganizerApproved::class])->group(function () {
            Route::get('/dashboard', function () {
                $userId = Auth::id();

                $eventsCount = Event::where('user_id', $userId)->count();
                $ticketsSold = Booking::whereHas('ticket.event', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                    ->where('status', 'approved')
                    ->sum('quantity');
                $revenue = Booking::whereHas('ticket.event', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                    ->where('status', 'approved')
                    ->sum('total_price');

                $recentBookings = Booking::with(['user', 'ticket.event'])
                    ->whereHas('ticket.event', function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    })
                    ->where('status', 'approved')
                    ->latest()
                    ->take(5)
                    ->get();

                return view('organizer.dashboard', compact('eventsCount', 'ticketsSold', 'revenue', 'recentBookings'));
            })->name('dashboard');

            // Resource Event, Tiket, dll
            Route::resource('events', EventController::class);
            Route::get('/events/{event}/tickets', [TicketController::class, 'index'])->name('events.tickets.index');
            Route::get('/events/{event}/tickets/create', [TicketController::class, 'create'])->name('events.tickets.create');
            Route::post('/events/{event}/tickets', [TicketController::class, 'store'])->name('events.tickets.store');
            Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
            Route::get('/events/{event}/bookings', [ReportController::class, 'index'])->name('events.bookings');
            Route::patch('/bookings/{booking}/status', [ReportController::class, 'updateStatus'])->name('bookings.updateStatus');
        });
    });

// --- GROUP USER (REGISTERED) ---
Route::middleware(['auth', 'role:user'])
    ->name('user.')
    ->group(function () {
        // Route Booking
        Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::post('/booking', [BookingController::class, 'store'])->name('bookings.store');
        Route::patch('/booking/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
        // Route Lihat Tiket Digital
        Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::get('/my-favorites', [FavoriteController::class, 'index'])->name('favorites.index');
        Route::post('/events/{event}/favorite', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';