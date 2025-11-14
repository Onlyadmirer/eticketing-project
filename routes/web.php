<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\UserManagement;
use App\Livewire\Event\CreateEvent;
use App\Livewire\Event\EditEvent;
use App\Livewire\Event\ListEvents;

require __DIR__.'/auth.php';


Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Route untuk /admin/users
    Route::get('users', UserManagement::class)->name('users');

    // (Nanti kita tambahkan rute event management di sini)
});

// Grup Rute untuk fitur yang butuh Admin atau Organizer Approved
Route::middleware(['auth', 'can-manage-events'])->group(function () {
    // Rute untuk /events/create
    Route::get('events/create', CreateEvent::class)->name('events.create');
    
    // (Nanti rute list event, edit event, dll akan ada di sini juga)
    Route::get('events', ListEvents::class)->name('events.index');
    Route::get('events/{event}/edit', EditEvent::class)->name('events.edit');
});