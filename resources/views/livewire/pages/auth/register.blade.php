<?php

// resources/views/livewire/pages/auth/register.blade.php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    // Properti untuk checkbox
    public bool $is_organizer = false;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        // 1. Validasi semua input, TERMASUK checkbox
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'is_organizer' => ['required', 'boolean'], // <-- Validasi checkbox
        ]);

        // 2. Tentukan role dan status
        $role = $validated['is_organizer'] ? 'organizer' : 'user';
        $status = $validated['is_organizer'] ? 'pending' : null;

        // 3. Buat SATU user dengan SEMUA data yang benar
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // <-- Hash HANYA SEKALI di sini
            'role' => $role,
            'organizer_status' => $status,
        ]);

        // 4. Kirim event dengan user yang baru dibuat
        event(new Registered($user));

        // 5. Login user tersebut
        Auth::login($user);

        // 6. Redirect ke dashboard
        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
  <form wire:submit="register">
    <!-- Name -->
    <div>
      <x-input-label for="name" :value="__('Name')" />
      <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required
        autofocus autocomplete="name" />
      <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div class="mt-4">
      <x-input-label for="email" :value="__('Email')" />
      <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required
        autocomplete="username" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
      <x-input-label for="password" :value="__('Password')" />

      <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password"
        required autocomplete="new-password" />

      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
      <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

      <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
        type="password" name="password_confirmation" required autocomplete="new-password" />

      <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <!-- 👇 INI ADALAH CHECKBOX YANG HILANG. SAYA TAMBAHKAN KEMBALI 👇 -->
    <div class="block mt-4">
      <label for="is_organizer" class="inline-flex items-center">
        <input wire:model="is_organizer" id="is_organizer" type="checkbox"
          class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_organizer">
        <span class="ms-2 text-sm text-gray-600">{{ __('Daftar sebagai Event Organizer') }}</span>
      </label>
      <x-input-error :messages="$errors->get('is_organizer')" class="mt-2" />
    </div>
    <!-- 👆 BATAS BLOK TAMBAHAN 👆 -->

    <div class="flex items-center justify-end mt-4">
      <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        href="{{ route('login') }}" wire:navigate>
        {{ __('Already registered?') }}
      </a>

      <x-primary-button class="ms-4">
        {{ __('Register') }}
      </x-primary-button>
    </div>
  </form>
</div>
