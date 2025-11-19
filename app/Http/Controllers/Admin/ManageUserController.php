<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ManageUserController extends Controller
{
    // Menampilkan daftar user
    public function index()
    {
        // Ambil semua user kecuali admin itu sendiri, urutkan yang terbaru
        $users = User::where('role', '!=', 'admin')->latest()->get();

        return view('admin.users.index', compact('users'));
    }

    // Mengubah status organizer (Approve/Reject)
    public function verifyOrganizer(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi input (hanya boleh approved atau rejected)
        $request->validate([
            'organizer_status' => 'required|in:approved,rejected',
        ]);

        // Update status
        $user->update([
            'organizer_status' => $request->input('organizer_status'),
        ]);

        return redirect()->back()->with('success', 'Status organizer berhasil diperbarui!');
    }

    // Menghapus user (Opsional, jika reject ingin sekalian hapus)
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}