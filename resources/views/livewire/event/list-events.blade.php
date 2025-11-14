<div>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Kelola Acara') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">

          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Acara
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>

                @if (auth()->user()->isAdmin())
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organizer
                  </th>
                @endif

                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @forelse ($events as $event)
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->name }}"
                      class="h-16 w-16 object-cover">
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ $event->name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    {{ \Carbon\Carbon::parse($event->event_time)->format('d M Y, H:i') }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ $event->location }}</td>

                  @if (auth()->user()->isAdmin())
                    <td class="px-6 py-4 whitespace-nowrap">{{ $event->user->name }}</td>
                  @endif

                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="{{ route('events.edit', $event) }}" wire:navigate
                      class="text-indigo-600 hover:text-indigo-900">Edit</a>

                    <button wire:click="delete({{ $event->id }})"
                      wire:confirm="Apakah Anda yakin ingin menghapus acara ini?"
                      class="ml-4 text-red-600 hover:text-red-900">
                      Hapus
                    </button>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                    Belum ada acara yang dibuat.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>

          <div class="mt-4">
            {{ $events->links() }}
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
