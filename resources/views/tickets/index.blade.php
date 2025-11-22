<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      Manajemen Tiket: {{ $event->title }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

      <div class="flex justify-between mb-4">
        <a href="{{ Auth::user()->role === 'admin' ? route('admin.events.index') : route('organizer.events.index') }}"
          class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-700">
          &larr; Kembali ke Event
        </a>

        <a href="{{ Auth::user()->role === 'admin' ? route('admin.events.tickets.create', $event->id) : route('organizer.events.tickets.create', $event->id) }}"
          class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700">
          + Tambah Tiket Baru
        </a>
      </div>

      @if (session('success'))
        <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
          {{ session('success') }}
        </div>
      @endif

      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          @if ($tickets->count() > 0)
            <table class="min-w-full border border-collapse border-gray-200 table-auto">
              <thead>
                <tr class="bg-gray-100">
                  <th class="px-4 py-2 border">Nama Tiket</th>
                  <th class="px-4 py-2 border">Harga</th>
                  <th class="px-4 py-2 border">Kuota</th>
                  <th class="px-4 py-2 border">Deskripsi</th>
                  <th class="px-4 py-2 border">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tickets as $ticket)
                  <tr>
                    <td class="px-4 py-2 border">{{ $ticket->name }}</td>
                    <td class="px-4 py-2 border">Rp {{ number_format($ticket->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 border">{{ $ticket->quota }}</td>
                    <td class="px-4 py-2 text-sm text-gray-600 border">{{ $ticket->description ?? '-' }}</td>
                    <td class="px-4 py-2 text-center border">
                      <form
                        action="{{ Auth::user()->role === 'admin' ? route('admin.tickets.destroy', $ticket->id) : route('organizer.tickets.destroy', $ticket->id) }}"
                        method="POST" onsubmit="return confirm('Hapus tiket ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-red-500 hover:underline">Hapus</button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @else
            <p class="text-center text-gray-500">Belum ada tiket untuk event ini.</p>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
