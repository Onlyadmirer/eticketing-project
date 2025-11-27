<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-white">
      Laporan Peserta: <span class="text-lime-400">{{ $event->title }}</span>
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

      <div class="flex flex-col items-center justify-between gap-4 mb-6 sm:flex-row">
        <a href="{{ Auth::user()->role === 'admin' ? route('admin.events.index') : route('organizer.events.index') }}"
          class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-gray-300 transition border border-gray-600 rounded-lg hover:bg-gray-800 hover:text-white">
          &larr; Kembali ke Daftar Event
        </a>

        <div
          class="px-5 py-2 font-bold border rounded-lg shadow-lg text-lime-400 bg-lime-400/10 border-lime-400/20 shadow-lime-400/5">
          Terjual: <span class="ml-1 text-lg text-white">{{ $bookings->sum('quantity') }}</span> Tiket
        </div>
      </div>

      <div class="bg-[#27272a] border border-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 text-gray-100">

          @if ($bookings->count() > 0)
            <div class="overflow-x-auto">
              <table class="min-w-full border border-collapse border-gray-700 table-auto">
                <thead>
                  <tr class="text-xs font-bold tracking-wider text-left text-gray-300 uppercase bg-black/30">
                    <th class="px-4 py-3 border border-gray-700">No</th>
                    <th class="px-4 py-3 border border-gray-700">Nama Peserta</th>
                    <th class="px-4 py-3 border border-gray-700">Email</th>
                    <th class="px-4 py-3 border border-gray-700">Kode Booking</th>
                    <th class="px-4 py-3 border border-gray-700">Jenis Tiket</th>
                    <th class="px-4 py-3 border border-gray-700">Waktu Pesan</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                  @foreach ($bookings as $index => $booking)
                    <tr class="transition duration-150 hover:bg-white/5">
                      <td class="px-4 py-3 text-center text-gray-300 border border-gray-700">{{ $index + 1 }}</td>
                      <td class="px-4 py-3 font-bold text-white border border-gray-700">
                        {{ $booking->user->name }}
                      </td>
                      <td class="px-4 py-3 text-gray-300 border border-gray-700">
                        {{ $booking->user->email }}
                      </td>
                      <td class="px-4 py-3 font-mono font-bold tracking-wide border border-gray-700 text-lime-400">
                        {{ $booking->booking_code }}
                      </td>
                      <td class="px-4 py-3 border border-gray-700">
                        <span class="block font-medium text-white">{{ $booking->ticket->name }}</span>
                        <span class="text-xs text-gray-300">
                          (Rp {{ number_format($booking->ticket->price, 0, ',', '.') }})
                        </span>
                      </td>
                      <td class="px-4 py-3 text-sm text-gray-300 border border-gray-700">
                        {{ $booking->created_at->format('d M Y, H:i') }}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot class="font-bold text-white bg-lime-900/20">
                  <tr>
                    <td colspan="3"
                      class="px-4 py-4 tracking-wide text-center uppercase border border-gray-700 text-lime-400">
                      Grand Total
                    </td>
                    <td class="px-4 py-4 text-lg text-center border border-gray-700 text-lime-400">
                      {{ $totalTickets }}
                    </td>
                    <td class="px-4 py-4 text-lg text-right border border-gray-700 text-lime-400">
                      Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </td>
                    <td class="border border-gray-700"></td>
                  </tr>
                </tfoot>
              </table>
            </div>

            <div class="mt-6 text-right">
              <button type="button" onclick="window.print()"
                class="flex items-center justify-end gap-1 ml-auto text-sm text-gray-400 hover:text-white hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-4 h-4">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                </svg>
                Cetak Laporan
              </button>
            </div>
          @else
            <div class="py-12 text-center border border-gray-700 border-dashed rounded bg-black/20">
              <div
                class="inline-flex items-center justify-center w-12 h-12 mb-3 text-gray-300 bg-gray-800 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
              </div>
              <p class="text-lg text-gray-400">Belum ada yang memesan tiket.</p>
              <p class="mt-1 text-xs text-gray-300">Promosikan event Anda untuk mendapatkan peserta!</p>
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
