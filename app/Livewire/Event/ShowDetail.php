<?php

namespace App\Livewire\Event;

use App\Models\Event;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ShowDetail extends Component
{
    public Event $event;

    /**
     * Method 'mount' dijalankan saat komponen di-load.
     */
    public function mount(Event $event)
    {
        // 2. Otorisasi: Cek apakah organizer event ini sudah approved.
        // Jika belum, jangan tampilkan halamannya.
        if ($event->user->organizer_status !== 'approved') {
            abort(404); // Tampilkan halaman Not Found
        }

        // 3. Muat relasi tiket agar bisa kita tampilkan
        $event->load('tickets');

        $this->event = $event;
    }

    public function render()
    {
        return view('livewire.event.show-detail');
    }
}