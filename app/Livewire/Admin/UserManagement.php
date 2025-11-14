<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class UserManagement extends Component
{
    use WithPagination; // Gunakan pagination

    // Fungsi untuk approve organizer
    public function approve(User $user)
    {
        $user->update([
            'organizer_status' => 'approved',
        ]);
    }

    // Fungsi untuk reject organizer
    public function reject(User $user)
    {
        $user->update([
            'organizer_status' => 'rejected',
        ]);
    }

    // Fungsi render() adalah yang dipanggil untuk menampilkan view
    public function render()
    {
        // Ambil semua user, urutkan berdasarkan role, dan paginasi
        $users = User::orderBy('role')->paginate(10);

        // Kirim data 'users' ke view
        return view('livewire.admin.user-management', [
            'users' => $users,
        ]);
    }
}