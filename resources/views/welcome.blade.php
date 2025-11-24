<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="corporate">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E-Ticketing Event</title>
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>




<body class="font-sans antialiased text-white bg-[#18181b]">

  <nav x-data="{ open: false }" class="bg-[#18181b] border-b border-gray-800 text-white py-2 sticky top-0 z-50">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-14">

        <div class="flex items-center">
          <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('welcome') }}" class="flex items-center gap-2 group">
              <div class="transition-transform text-lime-400 group-hover:rotate-12">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                  <path fill-rule="evenodd"
                    d="M1.5 6.375c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v3.026a.75.75 0 0 1-.375.65 2.249 2.249 0 0 0 0 3.898.75.75 0 0 1 .375.65v3.026c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 17.625v-3.026a.75.75 0 0 1 .374-.65 2.249 2.249 0 0 0 0-3.898.75.75 0 0 1-.374-.65V6.375Zm15-1.125a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-1.5 0V6a.75.75 0 0 1 .75-.75Zm.75 4.5a.75.75 0 0 0-1.5 0v.75a.75.75 0 0 0 1.5 0v-.75Zm-.75 3a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-1.5 0v-.75a.75.75 0 0 1 .75-.75Z"
                    clip-rule="evenodd" />
                </svg>
              </div>
              <span class="text-xl font-bold tracking-wide text-white">TicketGo</span>
            </a>
          </div>
        </div>

        <div class="hidden space-x-6 sm:flex sm:items-center sm:ms-auto">

          <a href="{{ route('welcome') }}"
            class="text-sm font-bold transition duration-150 ease-in-out {{ request()->routeIs('welcome') ? 'text-lime-400' : 'text-gray-300 hover:text-white' }}">
            Home
          </a>

          @auth
            <a href="{{ route('dashboard') }}"
              class="text-sm font-bold text-gray-300 transition hover:text-white">Dashboard</a>

            @if (Auth::user()->role === 'admin')
              <a href="{{ route('admin.users.index') }}" class="text-sm font-bold text-gray-300 hover:text-white">Manage
                Users</a>
              <a href="{{ route('admin.events.index') }}" class="text-sm font-bold text-gray-300 hover:text-white">Manage
                Events</a>
            @endif

            @if (Auth::user()->role === 'organizer')
              <a href="{{ route('organizer.events.index') }}" class="text-sm font-bold text-gray-300 hover:text-white">My
                Events</a>
            @endif

            <div class="relative ms-2">
              <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                  <button
                    class="inline-flex items-center px-3 py-2 text-sm font-bold leading-4 text-gray-300 transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:text-white hover:bg-gray-700 focus:outline-none">
                    <div>{{ Auth::user()->name }}</div>
                    <div class="ms-1">
                      <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                          clip-rule="evenodd" />
                      </svg>
                    </div>
                  </button>
                </x-slot>
                <x-slot name="content">
                  <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                      onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                  </form>
                </x-slot>
              </x-dropdown>
            </div>
          @else
            <a href="{{ route('login') }}" class="text-sm font-bold text-gray-300 transition hover:text-white">Log in</a>
            @if (Route::has('register'))
              <a href="{{ route('register') }}"
                class="px-4 py-2 text-sm font-bold text-gray-900 transition rounded bg-lime-400 hover:bg-lime-300">
                Register
              </a>
            @endif
          @endauth
        </div>

        <div class="flex items-center -me-2 sm:hidden">
          <button @click="open = ! open"
            class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white">
            <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
              <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-[#18181b] border-t border-gray-800">
      <div class="pt-2 pb-3 space-y-1">
        <a href="{{ route('welcome') }}"
          class="block w-full ps-3 pe-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out {{ request()->routeIs('welcome') ? 'border-lime-400 text-lime-400 bg-gray-800' : 'border-transparent text-gray-300 hover:text-white hover:bg-gray-800' }}">Home</a>

        @auth
          <a href="{{ route('dashboard') }}"
            class="text-sm font-bold transition duration-150 ease-in-out {{ request()->routeIs('dashboard') || request()->routeIs('user.bookings.*') ? 'text-lime-400' : 'text-gray-300 hover:text-white' }}">
            Dashboard
          </a>

          @if (Auth::user()->role === 'admin')
            <a href="{{ route('admin.users.index') }}"
              class="block w-full py-2 text-gray-300 border-l-4 border-transparent ps-3 pe-4 hover:text-white hover:bg-gray-800">Manage
              Users</a>
            <a href="{{ route('admin.events.index') }}"
              class="block w-full py-2 text-gray-300 border-l-4 border-transparent ps-3 pe-4 hover:text-white hover:bg-gray-800">Manage
              Events</a>
          @endif

          @if (Auth::user()->role === 'organizer')
            <a href="{{ route('organizer.events.index') }}"
              class="block w-full py-2 text-gray-300 border-l-4 border-transparent ps-3 pe-4 hover:text-white hover:bg-gray-800">My
              Events</a>
          @endif
        @else
          <a href="{{ route('login') }}"
            class="block w-full py-2 text-gray-300 border-l-4 border-transparent ps-3 pe-4 hover:text-white hover:bg-gray-800">Log
            in</a>
          <a href="{{ route('register') }}"
            class="block w-full py-2 bg-gray-800 border-l-4 ps-3 pe-4 border-lime-400 text-lime-400">Register</a>
        @endauth
      </div>
    </div>
  </nav>

  {{-- #B4E900 --}}
  {{-- #89DF1B --}}
  <div class="relative pt-32 pb-20 overflow-hidden lg:pt-38 lg:pb-32">

    <div class="absolute inset-0 ">
      <img src="/img/hero-bg.jpg" class="object-cover w-full h-full opacity-40" alt="Concert Background">

      <div class="absolute inset-0 bg-gradient-to-b from-[#18181b]/20 via-[#18181b]/10 to-[#18181b]"></div>
    </div>

    <div class="relative z-10 px-4 mx-auto text-center max-w-7xl">

      <span
        class="inline-block px-3 py-1 mb-6 text-xs font-bold tracking-wider uppercase border rounded-full bg-lime-400/10 border-lime-400/20 backdrop-blur-md text-lime-400">
        Platform Tiket Paling Hype
      </span>

      <h1 class="mb-6 text-5xl font-black leading-tight tracking-tight text-white md:text-7xl">
        Temukan Event <br>
        <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-emerald-400">Seru di
          Sekitarmu!</span>
      </h1>

      <p class="max-w-2xl mx-auto mb-10 text-lg text-gray-300 md:text-xl">
        Konser, Workshop, Seminar, dan banyak lagi. Booking tiketmu sekarang sebelum kehabisan.
      </p>

      <form action="{{ route('welcome') }}" method="GET" class="relative w-full max-w-lg mx-auto group">
        <input type="text" name="search" placeholder="Cari konser, artis, atau lokasi..."
          class="w-full pl-6 text-base text-white placeholder-gray-400 transition-all border rounded-full shadow-xl h-14 pr-14 bg-white/10 border-white/20 backdrop-blur-md focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400"
          value="{{ request('search') }}">
        <button type="submit"
          class="absolute flex items-center justify-center w-10 h-10 text-black transition-transform duration-200 rounded-full shadow-lg top-2 right-2 bg-lime-400 hover:bg-lime-500 hover:scale-105"
          aria-label="Cari">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
            stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
          </svg>
        </button>
      </form>
    </div>
  </div>

  <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <h2 class="pl-3 mb-6 text-2xl font-bold border-l-4 border-[#89DF1B]">Event Terbaru</h2>

    @if ($events->count() > 0)
      <div class="grid grid-cols-1 gap-8 px-4 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($events as $event)
          <div
            class="group bg-[#27272a] rounded-2xl overflow-hidden border border-gray-800 hover:border-lime-800 transition-all duration-300 shadow-lg relative flex flex-col h-full">

            <div class="relative overflow-hidden h-52">
              @if ($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}"
                  class="object-cover w-full h-full transition duration-700 ease-out transform group-hover:scale-105">
              @else
                <div class="flex items-center justify-center w-full h-full bg-gray-800">
                  <span class="font-bold text-gray-600">No Image</span>
                </div>
              @endif

              <div
                class="absolute px-3 py-1 font-bold text-center text-black rounded-md shadow-lg top-3 left-3 bg-lime-400">
                <span
                  class="block text-xs tracking-wide uppercase">{{ \Carbon\Carbon::parse($event->start_time)->format('M') }}</span>
                <span
                  class="block text-xl leading-none">{{ \Carbon\Carbon::parse($event->start_time)->format('d') }}</span>
              </div>

              <div class="absolute inset-0 bg-gradient-to-t from-[#27272a] to-transparent opacity-60"></div>
            </div>

            <div class="flex flex-col flex-1 px-6 py-4">
              <div class="flex items-center gap-2 mb-3 text-xs font-medium text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                  class="w-4 h-4 text-lime-400">
                  <path fill-rule="evenodd"
                    d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z"
                    clip-rule="evenodd" />
                </svg>
                <span class="tracking-wide uppercase">{{ $event->location }}</span>
              </div>

              <h3 class="mb-2 text-xl font-bold text-white transition-colors line-clamp-1 group-hover:text-lime-400">
                {{ $event->title }}
              </h3>

              <p class="flex-1 mb-6 text-sm text-gray-400 line-clamp-2">
                {{ $event->description }}
              </p>

              <div class="flex items-center justify-between pt-4 mt-auto border-t border-gray-700">
                <div>
                  <p class="text-xs text-gray-500">Mulai dari</p>
                  <p class="text-lg font-bold text-lime-400">
                    IDR {{ number_format($event->tickets->min('price') ?? 0, 0, ',', '.') }}
                  </p>
                </div>

                <a href="{{ route('event.detail', $event->id) }}"
                  class="px-4 py-2 text-sm font-bold text-black transition-all duration-300 transform bg-gray-100 shadow-md rounded-xl hover:bg-gray-300 ">
                  Beli Tiket
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="py-12 text-center">
        <p class="text-lg text-gray-500">Belum ada event yang tersedia saat ini.</p>
      </div>
    @endif
  </div>

  <footer class="py-8 mt-12 text-white bg-[#18181b] border-t border-gray-700">
    <div class="px-4 mx-auto text-center max-w-7xl">
      <p>&copy; {{ date('Y') }} E-Ticketing Project. All rights reserved.</p>
    </div>
  </footer>

</body>

</html>
