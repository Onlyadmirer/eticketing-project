<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-white ">
      {{ __('Tiket Saya') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

      @if (session('success'))
        <div class="relative px-4 py-3 mb-4 text-green-300 border border-green-600 rounded bg-green-900/50">
          {{ session('success') }}
        </div>
      @endif

      <div class="bg-[#27272a] border border-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 text-gray-100">

          @if ($bookings->count() > 0)
            <div class="overflow-x-auto">
              <table class="min-w-full border border-collapse border-gray-700 table-auto">
                <thead>
                  <tr class="text-left text-gray-300 bg-black/30">
                    <th class="px-4 py-3 border border-gray-700">Kode Booking</th>
                    <th class="px-4 py-3 border border-gray-700">Nama Event</th>
                    <th class="px-4 py-3 border border-gray-700">Jenis Tiket</th>
                    <th class="px-4 py-3 border border-gray-700">Tanggal Event</th>
                    <th class="px-4 py-3 border border-gray-700">Status</th>
                    <th class="px-4 py-3 border border-gray-700">Aksi</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                  @foreach ($bookings as $booking)
                    <tr class="transition hover:bg-white/5">
                      <td class="px-4 py-3 font-mono font-bold border border-gray-700 text-lime-400">
                        #{{ $booking->booking_code }}
                      </td>
                      <td class="px-4 py-3 font-semibold border border-gray-700">
                        {{ $booking->ticket->event->title ?? 'Event Dihapus' }}
                      </td>
                      <td class="px-4 py-3 text-gray-300 border border-gray-700">
                        {{ $booking->ticket->name }}
                        <span class="ml-1 text-xs font-bold text-lime-400">
                          (x{{ $booking->quantity }})
                        </span>
                      </td>
                      <td class="px-4 py-3 text-gray-300 border border-gray-700">
                        {{ \Carbon\Carbon::parse($booking->ticket->event->start_time)->format('d M Y, H:i') }}
                      </td>
                      <td class="px-4 py-3 border border-gray-700">
                        <span
                          class="px-2 py-1 rounded-full text-xs font-bold
                                                {{ $booking->status == 'approved' ? 'bg-green-500/20 text-green-400' : ($booking->status == 'pending' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-red-500/20 text-red-400') }}">
                          {{ ucfirst($booking->status) }}
                        </span>
                      </td>
                      <td class="px-4 py-3 text-sm border border-gray-700">
                        <a href="{{ route('event.detail', $booking->ticket->event->id) }}"
                          class="text-blue-400 transition hover:text-blue-300 hover:underline">
                          Lihat Event
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="py-12 text-center border border-gray-700 border-dashed rounded-lg bg-black/20">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-12 h-12 mx-auto mb-4 text-gray-600">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v9.652a1.125 1.125 0 0 0 .621 1.096l2.64 1.433a1.125 1.125 0 0 1 .589 1.014v.825c0 .621.504 1.125 1.125 1.125h10.5c.621 0 1.125-.504 1.125-1.125v-.825a1.125 1.125 0 0 1 .589-1.014l2.64-1.433a1.125 1.125 0 0 0 .621-1.096V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
              </svg>
              <p class="mb-4 text-lg text-gray-400">Kamu belum memesan tiket apapun.</p>
              <a href="/"
                class="px-6 py-3 font-bold text-black transition transform rounded-full shadow-lg bg-lime-400 hover:bg-lime-500 hover:scale-105 shadow-lime-400/20">
                Cari Event Sekarang
              </a>
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
