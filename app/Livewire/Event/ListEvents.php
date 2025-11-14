<?php

namespace App\Livewire\Event;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ListEvents extends Component
{
    use WithPagination; // <-- 2. Aktifkan pagination
    
    /**
     * Method baru untuk menghapus event.
    */
    public function delete(Event $event)
    {

        $user = Auth::user();
        
        /** @var \App\Models\User $user */
        // 2. Otorisasi: Cek apakah user adalah Admin ATAU pemilik event
        if (!$user->isAdmin() && $event->user_id !== Auth::id()) {
            // Jika bukan keduanya, gagalkan aksi
            abort(403, 'Anda tidak punya izin untuk menghapus acara ini.');
        }

        // 3. Hapus gambar dari storage
        // Pastikan file ada sebelum dihapus
        if ($event->image_path && Storage::disk('public')->exists($event->image_path)) {
            Storage::disk('public')->delete($event->image_path);
        }

        // 4. Hapus event dari database
        $event->delete();

        // 5. Beri notifikasi
        session()->flash('success', 'Acara berhasil dihapus.');

        // 6. Reset pagination (agar tidak error jika halaman terakhir jadi kosong)
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user(); // Baris ini sudah benar

        /** @var \App\Models\User $user */

        if ($user->isAdmin()) {
            // Admin melihat SEMUA event
            $events = Event::with('user')->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $events = $user->events()->orderBy('created_at', 'desc')->paginate(10);
        }

        return view('livewire.event.list-events', [
            'events' => $events,
        ]);
    }
}