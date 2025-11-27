<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-white">
      {{ __('Dashboard Statistik') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

      <div
        class="relative p-8 mb-8 overflow-hidden border border-gray-800 shadow-lg bg-gradient-to-r from-lime-500 to-lime-400 rounded-2xl">
        <div class="relative z-10">
          <h3 class="mb-2 text-2xl font-bold text-black">Halo, {{ Auth::user()->name }}! 👋</h3>
          <p class="max-w-xl text-gray-800">
            Selamat datang kembali di panel kontrol Event Organizer. Pantau penjualan tiketmu dan kelola event terbaru
            di sini.
          </p>
          <div class="mt-6">
            <a href="{{ route('organizer.events.create') }}"
              class="inline-flex items-center px-4 py-2 font-bold text-white transition transform bg-gray-700 rounded-lg shadow-lg hover:bg-gray-600 shadow-lime-400/20">
              + Buat Event Baru
            </a>
          </div>
        </div>
        <div
          class="absolute top-0 right-0 w-1/3 h-full pointer-events-none bg-gradient-to-l from-lime-400/10 to-transparent">
        </div>
      </div>

      <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">

        <div
          class="bg-[#27272a] border border-gray-800 p-6 rounded-2xl shadow-md hover:border-lime-400/50 transition duration-300">
          <div class="flex items-center gap-4">
            <div class="p-3 text-blue-400 bg-blue-900/30 rounded-xl">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
              </svg>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-300">Total Event Aktif</p>
              <h4 class="text-3xl font-black text-white">{{ $eventsCount }}</h4>
            </div>
          </div>
        </div>

        <div
          class="bg-[#27272a] border border-gray-800 p-6 rounded-2xl shadow-md hover:border-lime-400/50 transition duration-300">
          <div class="flex items-center gap-4">
            <div class="p-3 bg-lime-900/30 text-lime-400 rounded-xl">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v9.652a1.125 1.125 0 0 0 .621 1.096l2.64 1.433a1.125 1.125 0 0 1 .589 1.014v.825c0 .621.504 1.125 1.125 1.125h10.5c.621 0 1.125-.504 1.125-1.125v-.825a1.125 1.125 0 0 1 .589-1.014l2.64-1.433a1.125 1.125 0 0 0 .621-1.096V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
              </svg>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-300">Tiket Terjual</p>
              <h4 class="text-3xl font-black text-white">{{ $ticketsSold }}</h4>
            </div>
          </div>
        </div>

        <div
          class="bg-[#27272a] border border-gray-800 p-6 rounded-2xl shadow-md hover:border-lime-400/50 transition duration-300">
          <div class="flex items-center gap-4">
            <div class="p-3 text-purple-400 bg-purple-900/30 rounded-xl">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
              </svg>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-300">Estimasi Pendapatan</p>
              <h4 class="text-2xl font-black text-white">Rp {{ number_format($revenue, 0, ',', '.') }}</h4>
            </div>
          </div>
        </div>

      </div>

      <div class="mb-8 bg-[#27272a] border border-gray-800 rounded-2xl overflow-hidden shadow-lg">
        <div class="flex items-center justify-between p-6 border-b border-gray-800">
          <h3 class="flex items-center gap-2 text-lg font-bold text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-lime-400" viewBox="0 0 20 20"
              fill="currentColor">
              <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                clip-rule="evenodd" />
            </svg>
            Penjualan Terakhir
          </h3>
          <a href="{{ route('organizer.events.index') }}" class="text-xs text-lime-400 hover:underline">Lihat Semua
            Event &rarr;</a>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-sm text-left text-gray-400">
            <thead class="text-xs font-bold text-gray-300 uppercase bg-black/20">
              <tr>
                <th class="px-6 py-4">Waktu</th>
                <th class="px-6 py-4">Pembeli</th>
                <th class="px-6 py-4">Tiket</th>
                <th class="px-6 py-4 text-center">Qty</th>
                <th class="px-6 py-4 text-right">Total</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
              @forelse($recentBookings as $booking)
                <tr class="transition hover:bg-white/5">
                  <td class="px-6 py-4 text-xs">
                    <div class="font-bold text-white">{{ $booking->created_at->diffForHumans() }}</div>
                    <div class="text-gray-500">{{ $booking->created_at->format('d M, H:i') }}</div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="font-bold text-white">{{ $booking->user->name }}</div>
                    <div class="text-xs text-gray-500">{{ $booking->user->email }}</div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="font-bold text-lime-400">{{ $booking->ticket->event->title }}</div>
                    <div class="text-xs text-gray-400">{{ $booking->ticket->name }}</div>
                  </td>
                  <td class="px-6 py-4 text-center">
                    <span class="px-2 py-1 text-xs text-white bg-gray-700 rounded">x{{ $booking->quantity }}</span>
                  </td>
                  <td class="px-6 py-4 font-bold text-right text-white">
                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                  </td>
                </tr>
              @empty
                <tr class="text-center">
                  <td colspan="5" class="py-8">Belum ada penjualan.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

      </div>

      <div class="grid grid-cols-1 gap-4">
        <a href="{{ route('organizer.events.index') }}"
          class="block p-6 bg-[#27272a] border border-gray-800 rounded-xl hover:bg-gray-800 transition group">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
              <div class="p-2 transition bg-gray-700 rounded-lg group-hover:bg-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6 text-gray-300">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 1.875 1.875v12.75a1.875 1.875 0 0 1-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V6.375a1.875 1.875 0 0 1 1.875-1.875Z" />
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-white">Lihat Semua Event Saya</h4>
                <p class="text-sm text-gray-300">Kelola detail, harga tiket, dan laporan peserta.</p>
              </div>
            </div>
            <div class="text-gray-500 transition group-hover:text-lime-400 group-hover:translate-x-1">
              &rarr;
            </div>
          </div>
        </a>
      </div>

    </div>
  </div>
</x-app-layout>
