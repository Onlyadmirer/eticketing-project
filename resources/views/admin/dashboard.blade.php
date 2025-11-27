<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-white">
      {{ __('Admin Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

      <div class="bg-[#27272a] border border-gray-800 rounded-2xl p-8 mb-8 shadow-lg relative overflow-hidden">
        <div class="relative z-10">
          <h3 class="mb-2 text-3xl font-black text-white">Control Panel Admin ⚡</h3>
          <p class="max-w-2xl text-gray-300">
            Pantau seluruh aktivitas platform TicketGo. Kelola pengguna, verifikasi organizer, dan awasi event yang
            sedang berlangsung.
          </p>
        </div>
        <div
          class="absolute top-0 right-0 w-1/3 h-full pointer-events-none bg-gradient-to-l from-lime-400/10 to-transparent">
        </div>
      </div>

      <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">

        <div class="bg-[#27272a] border border-gray-800 p-6 rounded-2xl shadow-md flex items-center gap-4">
          <div class="p-3 text-blue-400 bg-blue-900/30 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
              stroke="currentColor" class="w-8 h-8">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
          </div>
          <div>
            <p class="text-sm font-bold text-gray-300">Registered Users</p>
            <h4 class="text-2xl font-black text-white">{{ $totalUsers }}</h4>
          </div>
        </div>

        <div class="bg-[#27272a] border border-gray-800 p-6 rounded-2xl shadow-md flex items-center gap-4">
          <div class="p-3 text-purple-400 bg-purple-900/30 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
              stroke="currentColor" class="w-8 h-8">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
            </svg>
          </div>
          <div>
            <p class="text-sm font-bold text-gray-300">Event Organizers</p>
            <h4 class="text-2xl font-black text-white">{{ $totalOrganizers }}</h4>
          </div>
        </div>

        <div
          class="bg-[#27272a] border {{ $pendingOrganizers > 0 ? 'border-yellow-500/50' : 'border-gray-800' }} p-6 rounded-2xl shadow-md flex items-center gap-4 relative overflow-hidden">
          @if ($pendingOrganizers > 0)
            <div class="absolute top-0 right-0 bg-yellow-500 text-black text-[10px] font-bold px-2 py-0.5 rounded-bl">
              ACTION NEEDED</div>
          @endif
          <div class="p-3 text-yellow-400 bg-yellow-900/30 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
              stroke="currentColor" class="w-8 h-8">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
            </svg>
          </div>
          <div>
            <p class="text-sm font-bold text-gray-300">Pending Approval</p>
            <h4 class="text-2xl font-black text-white">{{ $pendingOrganizers }}</h4>
          </div>
        </div>

        <div class="bg-[#27272a] border border-lime-500/30 p-6 rounded-2xl shadow-md flex items-center gap-4 relative">
          <div class="absolute top-0 right-0 w-20 h-20 rounded-full bg-lime-400 blur-2xl opacity-10"></div>
          <div class="z-10 p-3 bg-lime-900/30 text-lime-400 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
              stroke="currentColor" class="w-8 h-8">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
          </div>
          <div class="z-10">
            <p class="text-xs font-bold tracking-wider uppercase text-lime-400">Total Omset Sistem</p>
            <h4 class="text-2xl font-black text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
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
            Transaksi Terakhir (Live)
          </h3>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-sm text-left text-gray-400">
            <thead class="text-xs font-bold text-gray-300 uppercase bg-black/20">
              <tr>
                <th class="px-6 py-4">Waktu</th>
                <th class="px-6 py-4">Pembeli</th>
                <th class="px-6 py-4">Detail Event & Tiket</th>
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
                  <td colspan="5" class="py-8">Belum ada transaksi.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

        <div class="lg:col-span-2 bg-[#27272a] border border-gray-800 rounded-2xl overflow-hidden shadow-lg">
          <div class="flex items-center justify-between p-6 border-b border-gray-800">
            <h3 class="text-lg font-bold text-white">📊 Performa Organizer</h3>
            <a href="{{ route('admin.users.index') }}" class="text-xs text-lime-400 hover:underline">Kelola User
              &rarr;</a>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-300">
              <thead class="text-xs font-bold text-gray-300 uppercase bg-black/20">
                <tr>
                  <th class="px-6 py-4">Organizer</th>
                  <th class="px-6 py-4 text-center">Event Aktif</th>
                  <th class="px-6 py-4 text-center">Tiket Terjual</th>
                  <th class="px-6 py-4 text-right">Total Pendapatan</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-800">
                @forelse($organizerStats as $stats)
                  <tr class="transition hover:bg-white/5">
                    <td class="px-6 py-4">
                      <div class="font-bold text-white">{{ $stats->name }}</div>
                      <div class="text-xs text-gray-300">{{ $stats->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                      <span class="px-2 py-1 text-xs text-white bg-gray-700 rounded">{{ $stats->events_count }}</span>
                    </td>
                    <td class="px-6 py-4 font-mono text-center text-lime-400">
                      {{ $stats->total_sold }}
                    </td>
                    <td class="px-6 py-4 font-bold text-right text-white">
                      Rp {{ number_format($stats->total_revenue, 0, ',', '.') }}
                    </td>
                  </tr>
                @empty
                  <tr class="text-center">
                    <td colspan="4" class="py-8">Belum ada data organizer.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <div class="flex flex-col gap-4">
          <div class="bg-[#27272a] border border-gray-800 rounded-2xl p-6">
            <h3 class="mb-4 font-bold text-white">Aksi Cepat</h3>
            <div class="flex flex-col gap-3">
              <a href="{{ route('admin.users.index') }}"
                class="flex items-center justify-between p-4 transition bg-gray-800/50 rounded-xl hover:bg-lime-400 hover:text-black group">
                <span class="font-medium">Verifikasi Organizer</span>
                <span
                  class="px-2 py-1 text-xs text-white bg-gray-700 rounded group-hover:bg-black/20 group-hover:text-black">
                  {{ $pendingOrganizers }} Pending
                </span>
              </a>
              <a href="{{ route('admin.events.index') }}"
                class="flex items-center justify-between p-4 transition bg-gray-800/50 rounded-xl hover:bg-lime-400 hover:text-black group">
                <span class="font-medium">Lihat Semua Event</span>
                <span
                  class="px-2 py-1 text-xs text-white bg-gray-700 rounded group-hover:bg-black/20 group-hover:text-black">
                  {{ $totalEvents }} Event
                </span>
              </a>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</x-app-layout>
