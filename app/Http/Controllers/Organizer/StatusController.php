<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class StatusController extends Controller
{
    // Tampilkan Halaman Status
    public function index()
    {
        $user = Auth::user();

        if ($user->organizer_status === 'approved') {
            return redirect()->route('organizer.dashboard');
        }

        return view('organizer.status', compact('user'));
    }

    // Hapus Akun (Jika Rejected)
    public function destroy()
    {
        $user = User::find(Auth::id()); 

        Auth::guard('web')->logout();

        $user->delete();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/')->with('success', 'Akun Anda telah dihapus. Silakan daftar kembali.');
    }
}