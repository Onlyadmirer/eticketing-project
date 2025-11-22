<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Daftar Event Saya') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

      <div class="mb-4">
        <a href="{{ Auth::user()->role === 'admin' ? route('admin.events.create') : route('organizer.events.create') }}"
          class="px-4 py-2 text-white bg-green-500 rounded hover:bg-green-700">
          + Buat Event Baru
        </a>
      </div>

      @if (session('success'))
        <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
          {{ session('success') }}
        </div>
      @endif

      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <table class="min-w-full text-center border border-collapse border-gray-200 table-auto">
            <thead>
              <tr class="bg-gray-100">
                <th class="px-4 py-2 border">Poster</th>
                <th class="px-4 py-2 border">Nama Event</th>
                <th class="px-4 py-2 border">Waktu</th>
                <th class="px-4 py-2 border">Lokasi</th>
                <th class="px-4 py-2 border">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($events as $event)
                <tr>
                  <td class="flex justify-center px-4 py-2 border ">
                    @if ($event->image)
                      <img src="{{ asset('storage/' . $event->image) }}" class="object-cover w-16 h-16 rounded">
                    @else
                      <span class="text-gray-400">No Image</span>
                    @endif
                  </td>
                  <td class="px-4 py-2 border">{{ $event->title }}</td>
                  <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($event->start_time)->format('d M Y, H:i') }}
                  </td>
                  <td class="px-4 py-2 border">{{ $event->location }}</td>
                  <td class="px-4 py-2 border">
                    <div class="flex flex-col gap-1 text-center">
                      <a href="{{ Auth::user()->role === 'admin' ? route('admin.events.tickets.index', $event->id) : route('organizer.events.tickets.index', $event->id) }}"
                        class="px-2 py-1 mb-2 text-xs font-bold text-indigo-700 bg-indigo-100 rounded hover:bg-indigo-200">
                        🎫 Kelola Tiket
                      </a>

                      <div class="flex justify-center gap-2 text-sm">
                        <a href="{{ Auth::user()->role === 'admin' ? route('admin.events.edit', $event->id) : route('organizer.events.edit', $event->id) }}"
                          class="font-bold text-yellow-500 hover:underline">
                          Edit
                        </a>

                        <span class="text-gray-300">|</span>

                        <form
                          action="{{ Auth::user()->role === 'admin' ? route('admin.events.destroy', $event->id) : route('organizer.events.destroy', $event->id) }}"
                          method="POST" onsubmit="return confirm('Hapus event ini?')">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                        </form>
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
