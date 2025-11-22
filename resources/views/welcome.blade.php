<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E-Ticketing Event</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50">

  <nav class="sticky top-0 z-50 bg-white shadow-sm">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex items-center">
          <a href="/" class="text-2xl font-bold text-blue-600">E-Ticket</a>
        </div>
        <div class="flex items-center space-x-4">
          @if (Route::has('login'))
            @auth
              <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-700 hover:text-blue-600">Dashboard</a>
            @else
              <a href="{{ route('login') }}" class="font-semibold text-gray-700 hover:text-blue-600">Log in</a>
              @if (Route::has('register'))
                <a href="{{ route('register') }}"
                  class="px-4 py-2 text-white transition bg-blue-600 rounded-md hover:bg-blue-700">Register</a>
              @endif
            @endauth
          @endif
        </div>
      </div>
    </div>
  </nav>

  <div class="py-16 bg-blue-600">
    <div class="px-4 mx-auto text-center text-white max-w-7xl sm:px-6 lg:px-8">
      <h1 class="mb-4 text-4xl font-extrabold">Temukan Event Seru di Sekitarmu!</h1>
      <p class="mb-8 text-lg">Konser, Workshop, Seminar, dan banyak lagi.</p>

      <form action="{{ route('welcome') }}" method="GET"
        class="flex max-w-lg p-1 mx-auto bg-white rounded-full shadow-lg">
        <input type="text" name="search" placeholder="Cari nama event atau lokasi..."
          class="flex-grow px-6 py-3 text-gray-800 rounded-l-full focus:outline-none" value="{{ request('search') }}">
        <button type="submit"
          class="px-6 py-3 font-bold text-white transition bg-blue-800 rounded-full hover:bg-blue-900">Cari</button>
      </form>
    </div>
  </div>

  <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <h2 class="pl-3 mb-6 text-2xl font-bold border-l-4 border-blue-500">Event Terbaru</h2>

    @if ($events->count() > 0)
      <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($events as $event)
          <div class="overflow-hidden transition duration-300 bg-white rounded-lg shadow-md hover:shadow-xl">
            <div class="h-48 overflow-hidden bg-gray-200">
              @if ($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}"
                  class="object-cover w-full h-full">
              @else
                <div class="flex items-center justify-center h-full text-gray-500">No Image</div>
              @endif
            </div>

            <div class="p-6">
              <div class="flex items-start justify-between">
                <div>
                  <p class="mb-1 text-sm font-semibold text-blue-600">
                    {{ \Carbon\Carbon::parse($event->start_time)->format('d M Y, H:i') }}</p>
                  <h3 class="mb-2 text-xl font-bold text-gray-900">{{ $event->title }}</h3>
                </div>
              </div>
              <p class="mb-4 text-sm text-gray-600 line-clamp-2">{{ $event->description }}</p>

              <div class="flex items-center mb-4 text-sm text-gray-500">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                {{ $event->location }}
              </div>

              <a href="{{ route('event.detail', $event->id) }}"
                class="block w-full py-2 text-center text-white transition bg-gray-800 rounded hover:bg-gray-900">
                Lihat Detail & Tiket
              </a>
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

  <footer class="py-8 mt-12 text-white bg-gray-800">
    <div class="px-4 mx-auto text-center max-w-7xl">
      <p>&copy; {{ date('Y') }} E-Ticketing Project. All rights reserved.</p>
    </div>
  </footer>

</body>

</html>
