<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'organizer') {
        return redirect()->route('organizer.dashboard');
    } else {
        return redirect()->route('user.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// --- GROUP ADMIN ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Manage Users Route
    Route::get('/users', [App\Http\Controllers\Admin\ManageUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{id}/verify', [App\Http\Controllers\Admin\ManageUserController::class, 'verifyOrganizer'])->name('users.verify');
    Route::delete('/users/{id}', [App\Http\Controllers\Admin\ManageUserController::class, 'destroy'])->name('users.destroy');
    });

// --- GROUP ORGANIZER ---
Route::middleware(['auth', 'role:organizer'])->prefix('organizer')->name('organizer.')->group(function () {
        Route::get('/dashboard', function () {
            return view('organizer.dashboard');
        })->name('dashboard');

        // Nanti kita tambahkan route event management milik organizer di sini
    });

// --- GROUP USER (REGISTERED) ---
Route::middleware(['auth', 'role:user'])->name('user.')->group(function () {
        Route::get('/user-dashboard', function () {
            return view('dashboard'); // View default breeze, nanti kita ubah isinya
        })->name('dashboard');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';