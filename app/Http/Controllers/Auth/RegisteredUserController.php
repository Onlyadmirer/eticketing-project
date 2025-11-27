<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'role' => ['required', 'string', 'in:user,organizer'], // Validasi Role
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Tentukan Status Organizer
        // Jika dia mendaftar sebagai Organizer -> Status = 'pending'
        // Jika user biasa -> Status = null
        $organizerStatus = null;
        if ($request->role === 'organizer') {
            $organizerStatus = 'pending';
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role, // Simpan Role
            'organizer_status' => $organizerStatus, // Simpan Status
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect cerdas sesuai Role
        return redirect(route('dashboard', absolute: false));
    }
}