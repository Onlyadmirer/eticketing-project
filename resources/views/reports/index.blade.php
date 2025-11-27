<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-white">
      Manajemen Peserta: <span class="text-lime-400">{{ $event->title }}</span>
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

      <div class="flex flex-col items-center justify-between gap-4 mb-6 sm:flex-row">
        <a href="{{ Auth::user()->role === 'admin' ? route('admin.events.index') : route('organizer.events.index') }}"
          class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-gray-300 transition border border-gray-600 rounded-lg hover:bg-gray-800 hover:text-white">
          &larr; Kembali
        </a>

        <div class="flex gap-3">
          <div class="px-4 py-2 font-bold text-white bg-gray-800 border border-gray-700 rounded-lg shadow">
            Tiket Terjual: <span class="ml-1 text-lime-400">{{ $totalTickets }}</span>
          </div>
          <div class="px-4 py-2 font-bold text-white bg-gray-800 border border-gray-700 rounded-lg shadow">
            Omset: <span class="ml-1 text-lime-400">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
          </div>
        </div>
      </div>

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
                  <tr class="text-xs font-bold tracking-wider text-left text-gray-300 uppercase bg-black/30">
                    <th class="px-4 py-3 border border-gray-700">Peserta</th>
                    <th class="px-4 py-3 border border-gray-700">Kode Booking</th>
                    <th class="px-4 py-3 text-center border border-gray-700">Qty</th>
                    <th class="px-4 py-3 text-right border border-gray-700">Total</th>
                    <th class="px-4 py-3 text-center border border-gray-700">Status</th>
                    <th class="px-4 py-3 text-center border border-gray-700">Aksi</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                  @foreach ($bookings as $booking)
                    <tr class="transition duration-150 hover:bg-white/5">
                      <td class="px-4 py-3 border border-gray-700">
                        <div class="font-bold text-white">{{ $booking->user->name }}</div>
                        <div class="text-xs text-gray-500">{{ $booking->user->email }}</div>
                      </td>
                      <td class="px-4 py-3 font-mono font-bold tracking-wide border border-gray-700 text-lime-400">
                        {{ $booking->booking_code }}
                        <div class="mt-1 font-sans text-xs text-gray-500">
                          {{ $booking->ticket->name }}
                        </div>
                      </td>
                      <td class="px-4 py-3 font-mono text-center border border-gray-700">
                        {{ $booking->quantity }}
                      </td>
                      <td class="px-4 py-3 font-bold text-right text-white border border-gray-700">
                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                      </td>

                      <td class="px-4 py-3 text-center border border-gray-700">
                        @if ($booking->status == 'approved')
                          <span
                            class="px-2 py-1 text-xs font-bold text-green-400 border rounded bg-green-500/20 border-green-500/30">Approved</span>
                        @elseif($booking->status == 'pending')
                          <span
                            class="px-2 py-1 text-xs font-bold text-yellow-400 border rounded bg-yellow-500/20 border-yellow-500/30 animate-pulse">Pending</span>
                        @else
                          <span
                            class="px-2 py-1 text-xs font-bold text-red-400 border rounded bg-red-500/20 border-red-500/30">Canceled</span>
                        @endif
                      </td>

                      <td class="px-4 py-3 text-center border border-gray-700">
                        <div class="flex justify-center gap-2">
                          @if ($booking->status !== 'approved')
                            <form
                              action="{{ Auth::user()->role === 'admin' ? route('admin.bookings.updateStatus', $booking->id) : route('organizer.bookings.updateStatus', $booking->id) }}"
                              method="POST">
                              @csrf
                              @method('PATCH')
                              <input type="hidden" name="status" value="approved">
                              <button type="submit"
                                class="p-1.5 bg-green-600 hover:bg-green-500 text-white rounded-lg transition"
                                title="Setujui">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                  class="w-4 h-4">
                                  <path fill-rule="evenodd"
                                    d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 0 1 1.04-.208Z"
                                    clip-rule="evenodd" />
                                </svg>
                              </button>
                            </form>
                          @endif

                          @if ($booking->status !== 'canceled')
                            <button type="button"
                              onclick="openCancelModal('{{ Auth::user()->role === 'admin' ? route('admin.bookings.updateStatus', $booking->id) : route('organizer.bookings.updateStatus', $booking->id) }}', '{{ $booking->booking_code }}', '{{ $booking->user->name }}')"
                              class="p-1.5 bg-red-600 hover:bg-red-500 text-white rounded-lg transition"
                              title="Batalkan Pesanan">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-4 h-4">
                                <path fill-rule="evenodd"
                                  d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                                  clip-rule="evenodd" />
                              </svg>
                            </button>
                          @endif
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot class="font-bold text-white bg-lime-900/20">
                  <tr>
                    <td colspan="3"
                      class="px-4 py-4 tracking-wide text-right uppercase border border-gray-700 text-lime-400">
                      Grand Total
                    </td>
                    <td class="px-4 py-4 text-lg text-center border border-gray-700 text-lime-400">
                      {{ $totalTickets }}
                    </td>
                    <td class="border border-gray-700"></td>
                    <td class="px-4 py-4 text-lg text-right border border-gray-700 text-lime-400">
                      Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>
          @else
            <div class="py-12 text-center">
              <p class="text-lg text-gray-500">Belum ada data pemesanan.</p>
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
              <h3 class="text-lg font-bold leading-6 text-white" id="modal-title">Batalkan Pemesanan?</h3>
              <div class="mt-2">
                <p class="text-sm text-gray-400">
                  Anda akan membatalkan tiket <span class="font-mono font-bold text-lime-400"
                    id="modalBookingCode">#CODE</span> <br>
                  milik peserta <span class="font-bold text-white" id="modalUserName">-</span>.
                </p>
                <p class="p-2 mt-3 text-xs font-semibold text-red-400 border rounded bg-red-900/20 border-red-900/50">
                  PERINGATAN: Kuota tiket akan dikembalikan ke sistem secara otomatis.
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="gap-2 px-4 py-3 bg-black/20 sm:px-6 sm:flex sm:flex-row-reverse">
          <form id="cancelForm" method="POST" action="">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="canceled">
            <button type="submit"
              class="inline-flex justify-center w-full px-4 py-2 text-base font-bold text-white transition bg-red-600 border border-transparent rounded-lg shadow-sm hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
              Ya, Batalkan
            </button>
          </form>
          <button type="button" onclick="closeCancelModal()"
            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-300 transition bg-gray-800 border border-gray-600 rounded-lg shadow-sm hover:text-white hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            Kembali
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function openCancelModal(actionUrl, bookingCode, userName) {
      document.getElementById('cancelForm').action = actionUrl;
      document.getElementById('modalBookingCode').innerText = bookingCode;
      document.getElementById('modalUserName').innerText = userName;
      document.getElementById('cancelModal').classList.remove('hidden');
    }

    function closeCancelModal() {
      document.getElementById('cancelModal').classList.add('hidden');
    }
  </script>

</x-app-layout>
