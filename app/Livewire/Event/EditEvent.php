<?php

namespace App\Livewire\Event;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads; // 1. Tentukan layout

#[Layout('layouts.app')]
class EditEvent extends Component
{
    use WithFileUploads;

    // Properti untuk menampung event yang akan diedit
    public Event $event;

    // Properti untuk form, sama seperti CreateEvent
    #[Rule('required', 'min:5', 'string')]
    public string $name = '';

    #[Rule('required', 'min:20', 'string')]
    public string $description = '';

    #[Rule('required', 'date')]
    public string $event_time = '';

    #[Rule('required', 'string', 'min:5')]
    public string $location = ''; // 'nullable' karena tidak wajib ganti

    // Untuk gambar baru (jika ada)
    #[Rule('nullable', 'image', 'max:2048')]
    public $new_image;

    // Untuk menyimpan path gambar lama
    public string $existing_image_path = '';

    #[Rule('required', 'string', 'min:3')]
    public string $ticket_name = '';

    #[Rule('nullable', 'string')]
    public string $ticket_description = '';

    #[Rule('required', 'numeric', 'min:0')]
    public $ticket_price = 0;

    #[Rule('required', 'integer', 'min:1')]
    public $ticket_quantity = 1;

    /**
     * Method 'mount' dijalankan saat komponen di-load.
     * Ini akan mengisi form dengan data event yang ada.
     */
    public function mount(Event $event)
    {
        // 1. Ambil user dan beri HINT untuk editor
        $user = Auth::user();
        /** @var \App\Models\User $user */

        // 2. Otorisasi:

        // $this->authorize('update', $event); // <-- INI PENYEBABNYA. Hapus/Komentari

        // Kita pakai pengecekan manual:
        if (!$user->isAdmin() && $event->user_id !== $user->id) {
            abort(403, 'Anda tidak punya izin untuk mengedit acara ini.');
        }

        // 3. Load data event ke properti komponen
        $this->event = $event;
        $this->name = $event->name;
        $this->description = $event->description;
        $this->event_time = \Carbon\Carbon::parse($event->event_time)->format('Y-m-d\TH:i');
        $this->location = $event->location;
        $this->existing_image_path = $event->image_path;
    }

    /**
     * Method untuk menyimpan perubahan
     */
    public function update()
    {
        // 4. Validasi data
        $validatedData = $this->validate();

        $imagePath = $this->existing_image_path; // Default pakai gambar lama

        // 5. Cek jika ada gambar baru di-upload
        if ($this->new_image) {
            // Hapus gambar lama
            if ($this->existing_image_path) {
                Storage::disk('public')->delete($this->existing_image_path);
            }
            // Simpan gambar baru
            $imagePath = $this->new_image->store('event_images', 'public');
        }

        // 6. Update data event di database
        $this->event->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'event_time' => $validatedData['event_time'],
            'location' => $validatedData['location'],
            'image_path' => $imagePath,
        ]);

        // 7. Beri notifikasi dan redirect
        session()->flash('success', 'Acara berhasil diperbarui.');
        return $this->redirect(route('events.index'), navigate: true);
    }

    public function addTicket()
    {
        // Validasi hanya field tiket
        $validated = $this->validate([
            'ticket_name' => 'required|string|min:3',
            'ticket_description' => 'nullable|string',
            'ticket_price' => 'required|numeric|min:0',
            'ticket_quantity' => 'required|integer|min:1',
        ]);

        // Buat tiket baru yang terhubung dengan event ini
        $this->event->tickets()->create([
            'name' => $validated["ticket_name"],
            'description' => $validated["ticket_description"],
            'price' => $validated["ticket_price"],
            'quantity' => $validated["ticket_quantity"],
        ]);

        // Beri notifikasi
        session()->flash('success_ticket', 'Tiket baru berhasil ditambahkan.');

        // Reset form tiket
        $this->reset('ticket_name', 'ticket_description', 'ticket_price', 'ticket_quantity');
    }

    public function render()
    {

        $this->event->load('tickets');
        return view('livewire.event.edit-event');
    }
}