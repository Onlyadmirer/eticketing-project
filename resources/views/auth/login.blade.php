<x-guest-layout>
  <x-auth-session-status class="mb-4" :status="session('status')" />

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <div>
      <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
      <x-text-input id="email"
        class="block w-full mt-1 text-white bg-gray-900 border-gray-700 focus:border-lime-400 focus:ring-lime-400"
        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div class="mt-4">
      <label for="password" class="block text-sm font-medium text-gray-300">Password</label>

      <x-text-input id="password"
        class="block w-full mt-1 text-white bg-gray-900 border-gray-700 focus:border-lime-400 focus:ring-lime-400"
        type="password" name="password" required autocomplete="current-password" />

      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <div class="block mt-4">
      <label for="remember_me" class="inline-flex items-center">
        <input id="remember_me" type="checkbox"
          class="bg-gray-900 border-gray-700 rounded shadow-sm text-lime-400 focus:ring-lime-400" name="remember">
        <span class="text-sm text-gray-400 ms-2">{{ __('Remember me') }}</span>
      </label>
    </div>

    <div class="flex items-center justify-end mt-4">
      @if (Route::has('password.request'))
        <a class="text-sm text-gray-400 underline rounded-md hover:text-lime-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500"
          href="{{ route('password.request') }}">
          {{ __('Forgot your password?') }}
        </a>
      @endif

      <x-primary-button
        class="font-bold text-black border-transparent ms-3 bg-lime-700 hover:bg-lime-500 focus:bg-lime-500 active:bg-lime-600">
        {{ __('Log in') }}
      </x-primary-button>
    </div>
  </form>
</x-guest-layout>
