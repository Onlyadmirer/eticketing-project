<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Jelajahi Event - TicketGo</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>

<body class="bg-[#18181b] text-white antialiased flex flex-col min-h-screen">

  @include('layouts.navigation_public')

  <div class="flex-grow px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">

    <div class="flex flex-col items-end justify-between gap-4 pt-10 mb-8 md:flex-row">
      <div>
        <h2 class="pl-4 mb-2 text-3xl font-bold text-white border-l-4 border-lime-400">
          Katalog Event
        </h2>
        <p class="ml-5 text-sm text-gray-400">Temukan event sesuai minatmu.</p>
      </div>

      <form action="{{ route('events.browse') }}" method="GET"
        class="flex flex-col w-full gap-3 lg:flex-row md:w-auto">

        <div class="relative w-full group lg:w-64">
          <input type="text" name="search" placeholder="Cari event..." value="{{ request('search') }}"
            class="w-full h-10 pl-4 pr-10 text-white bg-[#27272a] border border-gray-700 rounded-lg focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 placeholder-gray-500 text-sm transition">
          <button type="submit" class="absolute text-gray-400 top-2 right-2 hover:text-lime-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
          </button>
        </div>

        <select name="category" onchange="this.form.submit()"
          class="h-10 bg-[#27272a] border border-gray-700 text-white pl-3 pr-8 rounded-lg focus:border-lime-400 text-sm cursor-pointer w-full lg:w-40">
          <option value="">Semua Kategori</option>
          @foreach ($categories as $cat)
            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}
            </option>
          @endforeach
        </select>

        <select name="location" onchange="this.form.submit()"
          class="h-10 bg-[#27272a] border border-gray-700 text-white pl-3 pr-8 rounded-lg focus:border-lime-400 text-sm cursor-pointer w-full lg:w-40">
          <option value="">Semua Lokasi</option>
          @foreach ($locations as $loc)
            <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>{{ $loc }}
            </option>
          @endforeach
        </select>

        <select name="sort" onchange="this.form.submit()"
          class="h-10 bg-[#27272a] border border-gray-700 text-white pl-3 pr-8 rounded-lg focus:border-lime-400 text-sm cursor-pointer w-full lg:w-40">
          <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>📅 Terbaru</option>
          <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>📅 Terlama</option>
          <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>💰 Termurah</option>
          <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>💰 Termahal</option>
        </select>

        @if (request()->hasAny(['search', 'category', 'location', 'sort']))
          <a href="{{ route('events.browse') }}"
            class="flex items-center justify-center h-10 px-3 text-sm text-red-400 transition border rounded-lg border-red-500/50 hover:bg-red-500 hover:text-white"
            title="Reset Filter">
            ✕
          </a>
        @endif
      </form>
    </div>

    @if ($events->count() > 0)
      <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($events as $event)
          <div
            class="group bg-[#27272a] rounded-2xl overflow-hidden border border-gray-800 hover:border-lime-400 transition-all shadow-lg flex flex-col">
            <div class="relative h-48 overflow-hidden">
              @if ($event->image)
                <img src="{{ asset('storage/' . $event->image) }}"
                  class="object-cover w-full h-full transition duration-700 group-hover:scale-110">
              @else
                <div class="flex items-center justify-center w-full h-full bg-gray-800">No Image</div>
              @endif
              <div class="absolute px-3 py-1 font-bold text-center text-black rounded top-3 left-3 bg-lime-400">
                <span
                  class="block text-xs uppercase">{{ \Carbon\Carbon::parse($event->start_time)->format('M') }}</span>
                <span
                  class="block text-xl leading-none">{{ \Carbon\Carbon::parse($event->start_time)->format('d') }}</span>
              </div>
            </div>
            <div class="flex flex-col flex-1 p-5">
              <h3 class="mb-2 text-lg font-bold text-white line-clamp-1">{{ $event->title }}</h3>
              <p class="flex-1 mb-4 text-sm text-gray-400 line-clamp-2">{{ $event->description }}</p>
              <div class="flex items-center justify-between pt-4 mt-auto border-t border-gray-700">
                <span class="font-bold text-lime-400">IDR
                  {{ number_format($event->tickets_min_price ?? 0, 0, ',', '.') }}</span>
                <a href="{{ route('event.detail', ['id' => $event->id, 'from' => 'events']) }}"
                  class="text-sm text-white hover:underline">Detail &rarr;</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="mt-12">
        {{ $events->links() }}
      </div>
    @else
      <div class="text-center py-20 bg-[#27272a] rounded-2xl border border-dashed border-gray-700">
        <h3 class="text-xl font-bold text-white">Tidak ada event ditemukan</h3>
      </div>
    @endif

  </div>

  <footer class="py-8 mt-auto text-sm text-center text-gray-500 border-t border-gray-800 bg-black/30">
    &copy; 2025 TicketGo. All rights reserved.
  </footer>

</body>

</html>
