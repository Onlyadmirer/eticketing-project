<?php

namespace App\Livewire\Event;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;


#[Layout('layouts.app')]
class CreateEvent extends Component
{
    use WithFileUploads; // <-- 5. Aktifkan fitur upload file

    // Properti yang di-binding ke form
    #[Rule('required', 'min:5', 'string')]
    public string $name = '';

    #[Rule('required', 'min:20', 'string')]
    public string $description = '';

    #[Rule('required', 'date')]
    public string $event_time = ''; // Kita pakai string untuk input TANGGAL

    #[Rule('required', 'string', 'min:5')]
    public string $location = ''; // Validasi gambar, max 2MB

    #[Rule('required', 'image', 'max:2048')]
    public $image; // Tipe 'mixed' untuk file upload

    /**
     * Method untuk menyimpan event baru
     */
    public function save()
    {
        // 1. Jalankan validasi
        $validatedData = $this->validate();

        // 2. Simpan gambar
        // 'public/event_images' akan disimpan di 'storage/app/public/event_images'
        $imagePath = $this->image->store('event_images', 'public');

        // 3. Simpan data ke database
        Event::create([
            'user_id' => Auth::id(), // ID Organizer/Admin yang sedang login
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'event_time' => $validatedData['event_time'],
            'location' => $validatedData['location'],
            'image_path' => $imagePath, // Simpan path hasil upload
        ]);

        // 4. Beri notifikasi (opsional, tapi bagus)
        session()->flash('success', 'Acara berhasil dibuat!');

        // 5. Redirect ke halaman dashboard (untuk saat ini)
        return $this->redirect(route('dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.event.create-event');
    }
}