<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E-Ticket #{{ $booking->booking_code }} - TicketGo</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #18181b;
    }

    /* Pattern Background untuk kesan kertas tiket */
    .ticket-bg {
      background-image: radial-gradient(#27272a 15%, transparent 16%), radial-gradient(#27272a 15%, transparent 16%);
      background-size: 10px 10px;
      background-position: 0 0, 5px 5px;
    }
  </style>
</head>

<body class="flex items-center justify-center min-h-screen p-4 text-white">

  <div class="w-full max-w-md">

    <div class="flex items-center justify-between mb-6">
      <a href="{{ route('user.bookings.index') }}"
        class="flex items-center gap-2 text-sm font-bold text-gray-400 transition hover:text-white">
        &larr; Kembali
      </a>
      <span class="text-sm font-bold text-lime-400">E-TICKET</span>
    </div>

    <div class="relative overflow-hidden shadow-2xl bg-zinc-900 rounded-3xl">

      <div class="relative h-48">
        @if ($booking->ticket->event->image)
          <img src="{{ asset('storage/' . $booking->ticket->event->image) }}"
            class="object-cover w-full h-full opacity-80">
        @else
          <div class="flex items-center justify-center w-full h-full bg-gray-800">
            <span class="font-bold text-gray-500">TicketGo Event</span>
          </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-zinc-900 to-transparent"></div>

        <div class="absolute top-4 right-4">
          <span class="px-3 py-1 text-xs font-bold text-black rounded-full shadow-lg bg-lime-400">
            PAID & VERIFIED
          </span>
        </div>
      </div>

      <div class="relative px-8 pt-2 pb-8 -mt-12">
        <h1 class="mb-1 text-3xl font-black leading-tight text-white shadow-black drop-shadow-lg">
          {{ $booking->ticket->event->title }}
        </h1>
        <p class="flex items-center gap-1 mb-6 text-sm text-gray-300 shadow-black drop-shadow-md">
          <svg class="w-4 h-4 text-lime-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          {{ $booking->ticket->event->location }}
        </p>

        <div class="grid grid-cols-2 gap-4 mb-6">
          <div class="p-3 border rounded-xl bg-zinc-800/50 border-zinc-700">
            <p class="text-xs text-gray-500 uppercase">Tanggal</p>
            <p class="font-bold text-white">
              {{ \Carbon\Carbon::parse($booking->ticket->event->start_time)->format('d M Y') }}</p>
          </div>
          <div class="p-3 border rounded-xl bg-zinc-800/50 border-zinc-700">
            <p class="text-xs text-gray-500 uppercase">Jam</p>
            <p class="font-bold text-white">
              {{ \Carbon\Carbon::parse($booking->ticket->event->start_time)->format('H:i') }} WIB</p>
          </div>
          <div class="p-3 border rounded-xl bg-zinc-800/50 border-zinc-700">
            <p class="text-xs text-gray-500 uppercase">Tiket</p>
            <p class="font-bold text-lime-400">{{ $booking->ticket->name }}</p>
          </div>
          <div class="p-3 border rounded-xl bg-zinc-800/50 border-zinc-700">
            <p class="text-xs text-gray-500 uppercase">Jumlah</p>
            <p class="font-bold text-white">{{ $booking->quantity }} Orang</p>
          </div>
        </div>

        <div class="relative flex items-center justify-between my-8">
          <div class="absolute w-6 h-6 -ml-10 rounded-full bg-[#18181b]"></div>
          <div class="w-full border-t-2 border-dashed border-zinc-700"></div>
          <div class="absolute w-6 h-6 -mr-10 rounded-full bg-[#18181b]"></div>
        </div>

        <div class="text-center">
          <p class="mb-4 text-sm font-medium tracking-widest text-gray-500 uppercase">Scan Code at Entrance</p>

          <div class="inline-block p-4 bg-white rounded-2xl">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $booking->booking_code }}"
              alt="QR Code" class="w-40 h-40">
          </div>

          <p class="mt-4 font-mono text-2xl font-bold tracking-widest text-lime-400">
            {{ $booking->booking_code }}
          </p>

          <p class="mt-2 text-xs text-gray-600">
            Tunjukkan tiket ini kepada petugas saat masuk ke lokasi acara.
          </p>
        </div>

        <div class="mt-8">
          <button onclick="window.print()"
            class="w-full py-3 font-bold text-black transition bg-white rounded-xl hover:bg-gray-200">
            Download / Print Tiket
          </button>
        </div>

      </div>
    </div>

    <div class="mt-8 text-xs text-center text-gray-600">
      &copy; 2025 TicketGo. Official E-Ticket System.
    </div>

  </div>

</body>

</html>
