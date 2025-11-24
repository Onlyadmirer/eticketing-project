<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      Laporan Peserta: {{ $event->title }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

      <div class="flex items-center justify-between mb-4">
        <a href="{{ Auth::user()->role === 'admin' ? route('admin.events.index') : route('organizer.events.index') }}"
          class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-700">
          &larr; Kembali ke Daftar Event
        </a>

        <div class="px-4 py-2 font-bold text-blue-800 bg-blue-100 rounded-lg shadow">
          Total Peserta: {{ $bookings->count() }} Orang
        </div>
      </div>

      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">

          @if ($bookings->count() > 0)
            <div class="overflow-x-auto">
              <table class="min-w-full border border-collapse border-gray-200 table-auto">
                <thead>
                  <tr class="text-left bg-gray-100">
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Nama Peserta</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Kode Booking</th>
                    <th class="px-4 py-2 border">Jenis Tiket</th>
                    <th class="px-4 py-2 border">Waktu Pesan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($bookings as $index => $booking)
                    <tr class="hover:bg-gray-50">
                      <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                      <td class="px-4 py-2 font-bold border">{{ $booking->user->name }}</td>
                      <td class="px-4 py-2 border">{{ $booking->user->email }}</td>
                      <td class="px-4 py-2 font-mono text-blue-600 border">{{ $booking->booking_code }}</td>
                      <td class="px-4 py-2 border">
                        {{ $booking->ticket->name }} <br>
                        <span class="text-xs text-gray-500">(Rp
                          {{ number_format($booking->ticket->price, 0, ',', '.') }})</span>
                      </td>
                      <td class="px-4 py-2 text-sm text-gray-600 border">
                        {{ $booking->created_at->format('d M Y, H:i') }}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="py-8 text-center">
              <p class="text-lg text-gray-500">Belum ada yang memesan tiket untuk event ini.</p>
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
