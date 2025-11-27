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

  @include('layouts.navigation_public')

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

      <form action="{{ route('events.browse') }}" method="GET" class="relative w-full max-w-lg mx-auto group">
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
    <div class="flex flex-col items-end justify-between gap-4 mb-8 md:flex-row">

      <h2 class="pl-4 text-3xl font-bold text-white border-l-4 border-lime-400">
        Event Terbaru
      </h2>
    </div>

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
        <div class="col-start-2 mt-12 text-center">
          <a href="{{ route('events.browse') }}"
            class="inline-flex items-center gap-2 px-8 py-3 font-bold transition border rounded-full border-lime-400 text-lime-400 hover:bg-lime-400 hover:text-black">
            Lihat Semua Event &rarr;
          </a>
        </div>
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
