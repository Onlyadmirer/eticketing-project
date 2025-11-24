<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Tiket Saya') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

      @if (session('success'))
        <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
          {{ session('success') }}
        </div>
      @endif

      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">

          @if ($bookings->count() > 0)
            <div class="overflow-x-auto">
              <table class="min-w-full border border-collapse border-gray-200 table-auto">
                <thead>
                  <tr class="text-left bg-gray-100">
                    <th class="px-4 py-2 border">Kode Booking</th>
                    <th class="px-4 py-2 border">Nama Event</th>
                    <th class="px-4 py-2 border">Jenis Tiket</th>
                    <th class="px-4 py-2 border">Tanggal Event</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($bookings as $booking)
                    <tr class="hover:bg-gray-50">
                      <td class="px-4 py-2 font-mono font-bold text-blue-600 border">
                        #{{ $booking->booking_code }}
                      </td>
                      <td class="px-4 py-2 border">
                        {{ $booking->ticket->event->title ?? 'Event Dihapus' }}
                      </td>
                      <td class="px-4 py-2 border">
                        {{ $booking->ticket->name }}
                      </td>
                      <td class="px-4 py-2 border">
                        {{ \Carbon\Carbon::parse($booking->ticket->event->start_time)->format('d M Y, H:i') }}
                      </td>
                      <td class="px-4 py-2 border">
                        <span
                          class="px-2 py-1 rounded text-xs text-white 
                                                {{ $booking->status == 'approved' ? 'bg-green-500' : ($booking->status == 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                          {{ ucfirst($booking->status) }}
                        </span>
                      </td>
                      <td class="px-4 py-2 text-sm border">
                        <a href="{{ route('event.detail', $booking->ticket->event->id) }}"
                          class="text-blue-500 hover:underline">
                          Lihat Event
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="py-8 text-center">
              <p class="mb-4 text-lg text-gray-500">Kamu belum memesan tiket apapun.</p>
              <a href="/" class="px-6 py-2 text-white bg-blue-600 rounded-full hover:bg-blue-700">
                Cari Event Sekarang
              </a>
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
