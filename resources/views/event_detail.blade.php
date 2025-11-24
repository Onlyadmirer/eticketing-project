<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $event->title }} - E-Ticket</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50">

  <nav class="bg-white shadow-sm">
    <div class="flex items-center justify-between px-4 py-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <a href="/" class="text-xl font-bold text-blue-600">&larr; Kembali ke Home</a>
    </div>
  </nav>

  <div class="max-w-5xl px-4 py-10 mx-auto sm:px-6 lg:px-8">

    <div class="overflow-hidden bg-white shadow-lg rounded-xl">
      <div class="md:flex">
        <div class="bg-gray-200 md:w-1/2">
          @if ($event->image)
            <img src="{{ asset('storage/' . $event->image) }}" class="object-cover w-full h-full"
              style="min-height: 400px;">
          @else
            <div class="flex items-center justify-center h-full text-xl font-bold text-gray-500">No Image Available
            </div>
          @endif
        </div>

        <div class="p-8 md:w-1/2">
          <div class="text-sm font-semibold tracking-wide text-indigo-500 uppercase">Event Organizer:
            {{ $event->organizer->name }}</div>
          <h1 class="mt-2 text-3xl font-extrabold leading-8 text-gray-900">{{ $event->title }}</h1>

          <div class="flex items-center mt-4 text-gray-600">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            {{ \Carbon\Carbon::parse($event->start_time)->format('l, d F Y - H:i') }} WIB
          </div>

          <div class="flex items-center mt-2 text-gray-600">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            {{ $event->location }}
          </div>

          <div class="mt-6 text-gray-600">
            <h3 class="mb-2 font-bold text-gray-900">Deskripsi Acara</h3>
            <p class="text-sm leading-relaxed">{{ $event->description }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-10">
      <h2 class="mb-4 text-2xl font-bold text-gray-900">Pilih Tiket</h2>

      <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        @forelse($event->tickets as $ticket)
          <div class="relative p-6 transition bg-white border rounded-lg shadow-sm hover:shadow-md">
            <div class="flex items-center justify-between mb-2">
              <h3 class="text-xl font-bold text-gray-800">{{ $ticket->name }}</h3>
              <span class="text-lg font-bold text-blue-600">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
            </div>
            <p class="mb-4 text-sm text-gray-500">{{ $ticket->description ?? 'Tiket masuk reguler.' }}</p>

            <div class="flex items-center justify-between pt-4 mt-4 border-t">
              <span class="text-sm text-gray-500">Sisa Kuota: <strong>{{ $ticket->quota }}</strong></span>

              @if ($ticket->quota > 0)
                @auth
                  @if (Auth::user()->role === 'user')
                    <form action="{{ route('user.bookings.store') }}" method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin memesan tiket ini?');">
                      @csrf
                      <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                      <button type="submit"
                        class="px-4 py-2 font-bold text-white transition bg-blue-600 rounded shadow-md hover:bg-blue-700">
                        Pesan Sekarang
                      </button>
                    </form>
                  @else
                    <button disabled class="px-4 py-2 text-gray-500 bg-gray-300 rounded cursor-not-allowed">
                      Role Anda Tidak Bisa Pesan
                    </button>
                  @endif
                @else
                  <a href="{{ route('login') }}"
                    class="px-4 py-2 text-sm text-white transition bg-indigo-600 rounded hover:bg-indigo-700">
                    Login untuk Memesan
                  </a>
                @endauth
              @else
                <button disabled class="px-4 py-2 font-bold text-red-500 bg-red-100 rounded cursor-not-allowed">
                  HABIS
                </button>
              @endif
            </div>
          </div>
        @empty
          <div class="col-span-2 py-4 text-center text-gray-500 bg-gray-100 rounded">
            Belum ada tiket yang tersedia untuk acara ini.
          </div>
        @endforelse
      </div>
    </div>

  </div>

</body>

</html>
