<?php

use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\WelcomeController;
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
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
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
            return view('organizer.dashboard');
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