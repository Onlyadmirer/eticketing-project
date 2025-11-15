<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination; // <-- 1. Gunakan layout Breeze

#[Layout('layouts.app')]
class Homepage extends Component
{
    use WithPagination;

    public function render()
    {
        // 2. Ambil event
        $events = Event::query()
            // 'whereHas' untuk memfilter event berdasarkan relasi 'user'
            ->whereHas('user', function ($query) {
                // Hanya tampilkan event jika 'user' (organizer) statusnya 'approved'
                $query->where('organizer_status', 'approved');
            })
            // Tampilkan event yang akan datang terlebih dahulu
            ->where('event_time', '>=', now())
            ->orderBy('event_time', 'asc')
            ->paginate(9); // Tampilkan 9 event per halaman

        return view('livewire.homepage', [
            'events' => $events,
        ]);
    }
}