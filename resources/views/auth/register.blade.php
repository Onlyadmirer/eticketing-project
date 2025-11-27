<x-guest-layout>
  <form method="POST" action="{{ route('register') }}">
    @csrf

    <div>
      <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
      <x-text-input id="name"
        class="block w-full mt-1 text-white bg-gray-900 border-gray-700 focus:border-lime-400 focus:ring-lime-400"
        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
      <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div class="mt-4">
      <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
      <x-text-input id="email"
        class="block w-full mt-1 text-white bg-gray-900 border-gray-700 focus:border-lime-400 focus:ring-lime-400"
        type="email" name="email" :value="old('email')" required autocomplete="username" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div class="mt-4">
      <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
      <x-text-input id="password"
        class="block w-full mt-1 text-white bg-gray-900 border-gray-700 focus:border-lime-400 focus:ring-lime-400"
        type="password" name="password" required autocomplete="new-password" />
      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>


    <div class="mt-4">
      <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirm Password</label>
      <x-text-input id="password_confirmation"
        class="block w-full mt-1 text-white bg-gray-900 border-gray-700 focus:border-lime-400 focus:ring-lime-400"
        type="password" name="password_confirmation" required autocomplete="new-password" />
      <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>
    <div class="mt-4">
      <label for="role" class="block text-sm font-medium text-gray-300">Daftar Sebagai</label>

      <select id="role" name="role"
        class="block w-full mt-1 text-white bg-gray-900 border-gray-700 rounded-md shadow-sm focus:border-lime-400 focus:ring-lime-400"
        required>
        <option value="user">Pengunjung (Cari Tiket)</option>
        <option value="organizer">Event Organizer (Buat Event)</option>
      </select>
    </div>

    <div class="flex items-center justify-end mt-4">
      <a class="text-sm text-gray-400 underline rounded-md hover:text-lime-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500"
        href="{{ route('login') }}">
        {{ __('Already registered?') }}
      </a>

      <x-primary-button class="font-bold text-black border-transparent ms-4 bg-lime-700 hover:bg-lime-500">
        {{ __('Register') }}
      </x-primary-button>
    </div>
  </form>
</x-guest-layout>
