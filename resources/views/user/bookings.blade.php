<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-white">
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
      @if (session('error'))
        <div class="relative px-4 py-3 mb-4 text-red-300 border border-red-600 rounded bg-red-900/50">
          {{ session('error') }}
        </div>
      @endif

      <div class="bg-[#27272a] border border-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 text-gray-100">

          @if ($bookings->count() > 0)
            <div class="overflow-x-auto">
              <table class="min-w-full border border-collapse border-gray-700 table-auto">
                <thead>
                  <tr class="text-sm font-bold text-left text-gray-300 uppercase bg-black/30">
                    <th class="px-4 py-3 border border-gray-700">Kode Booking</th>
                    <th class="px-4 py-3 border border-gray-700">Event Info</th>
                    <th class="px-4 py-3 border border-gray-700">Total Bayar</th>
                    <th class="px-4 py-3 border border-gray-700">Status</th>
                    <th class="px-4 py-3 text-center border border-gray-700">Aksi</th>
                  </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-700">
                  @foreach ($bookings as $booking)
                    <tr class="transition hover:bg-white/5">
                      <td class="px-4 py-3 font-mono font-bold border border-gray-700 text-lime-400">
                        #{{ $booking->booking_code }}
                      </td>
                      <td class="px-4 py-3 border border-gray-700">
                        <div class="font-bold text-white">{{ $booking->ticket->event->title ?? 'Event Dihapus' }}</div>
                        <div class="text-xs text-gray-400">
                          {{ $booking->ticket->name }} (x{{ $booking->quantity }})
                        </div>
                        <div class="mt-1 text-xs text-gray-500">
                          {{ \Carbon\Carbon::parse($booking->ticket->event->start_time)->format('d M Y, H:i') }}
                        </div>
                      </td>
                      <td class="px-4 py-3 font-bold text-white border border-gray-700">
                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                      </td>
                      <td class="px-4 py-3 border border-gray-700">
                        @if ($booking->status == 'approved')
                          <span
                            class="px-2 py-1 text-xs font-bold text-green-400 border rounded-full bg-green-500/20 border-green-500/30">
                            Berhasil
                          </span>
                        @elseif($booking->status == 'pending')
                          <span
                            class="px-2 py-1 text-xs font-bold text-yellow-400 border rounded-full bg-yellow-500/20 border-yellow-500/30">
                            Menunggu
                          </span>
                        @else
                          <span
                            class="px-2 py-1 text-xs font-bold text-gray-400 bg-gray-700 border border-gray-600 rounded-full">
                            Dibatalkan
                          </span>
                        @endif
                      </td>
                      <td class="px-4 py-3 text-center border border-gray-700">
                        <div class="flex items-center justify-center gap-3">

                          @if ($booking->status == 'approved')
                            <a href="{{ route('user.bookings.show', $booking->id) }}"
                              class="inline-flex items-center gap-1 px-3 py-1 text-xs font-bold text-black transition rounded shadow-lg bg-lime-400 hover:bg-lime-500 shadow-lime-400/20">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-3 h-3">
                                <path fill-rule="evenodd"
                                  d="M1.5 6.375c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v3.026a.75.75 0 0 1-.375.65 2.249 2.249 0 0 0 0 3.898.75.75 0 0 1 .375.65v3.026c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 17.625v-3.026a.75.75 0 0 1 .374-.65 2.249 2.249 0 0 0 0-3.898.75.75 0 0 1-.374-.65V6.375Zm15-1.125a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-1.5 0V6a.75.75 0 0 1 .75-.75Zm.75 4.5a.75.75 0 0 0-1.5 0v.75a.75.75 0 0 0 1.5 0v-.75Zm-.75 3a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-1.5 0v-.75a.75.75 0 0 1 .75-.75Z"
                                  clip-rule="evenodd" />
                              </svg>
                              E-Ticket
                            </a>
                          @else
                            <a href="{{ route('event.detail', $booking->ticket->event->id) }}"
                              class="text-xs font-bold text-blue-400 hover:text-blue-300 hover:underline">
                              Info Event
                            </a>
                          @endif

                          @if ($booking->status !== 'canceled' && now()->lessThan(\Carbon\Carbon::parse($booking->ticket->event->start_time)))
                          @endif
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="py-12 text-center border border-gray-700 border-dashed rounded-lg bg-black/20">
              <p class="mb-4 text-lg text-gray-400">Kamu belum memesan tiket apapun.</p>
              <a href="/"
                class="px-6 py-3 font-bold text-black transition rounded-full shadow-lg bg-lime-400 hover:bg-lime-500 shadow-lime-400/20">
                Cari Event Sekarang
              </a>
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>

  <div id="cancelModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 transition-opacity bg-black/80 backdrop-blur-sm" aria-hidden="true"
        onclick="closeCancelModal()"></div>
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div
        class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-[#27272a] border border-gray-700 rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div
              class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto rounded-full bg-red-900/30 sm:mx-0 sm:h-10 sm:w-10">
              <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
              </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3 class="text-lg font-bold leading-6 text-white" id="modal-title">Batalkan Pesanan?</h3>
              <div class="mt-2">
                <p class="text-sm text-gray-400">
                  Anda akan membatalkan tiket untuk: <br>
                  <span class="font-bold text-white" id="cancelEventName">-</span>
                </p>
                <p class="mt-2 text-xs font-semibold text-red-400">
                  Tindakan ini akan mengembalikan kuota tiket ke sistem.
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="gap-2 px-4 py-3 bg-black/20 sm:px-6 sm:flex sm:flex-row-reverse">
          <form id="cancelForm" method="POST" action="">
            @csrf
            @method('PATCH')
            <button type="submit"
              class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white transition bg-red-600 border border-transparent rounded-lg shadow-sm hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
              Ya, Batalkan Tiket
            </button>
          </form>
          <button type="button" onclick="closeCancelModal()"
            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-300 transition bg-gray-800 border border-gray-600 rounded-lg shadow-sm hover:bg-gray-700 hover:text-white focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            Kembali
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function openCancelModal(url, eventName) {
      document.getElementById('cancelForm').action = url;
      document.getElementById('cancelEventName').innerText = eventName;
      document.getElementById('cancelModal').classList.remove('hidden');
    }

    function closeCancelModal() {
      document.getElementById('cancelModal').classList.add('hidden');
    }
  </script>

</x-app-layout>
