<div>
  {{-- Header Halaman --}}
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Daftar Acara Tersedia') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

      @if ($events->isEmpty())
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 text-center text-gray-900">
            {{ __('Saat ini belum ada acara yang tersedia.') }}
          </div>
        </div>
      @else
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

          @foreach ($events as $event)
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
              <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->name }}"
                class="object-cover w-full h-48">

              <div class="p-6">
                <h3 class="mb-2 text-lg font-semibold">{{ $event->name }}</h3>

                <div class="mb-1 text-sm text-gray-600">
                  <strong>Tanggal:</strong>
                  {{ \Carbon\Carbon::parse($event->event_time)->format('d M Y, H:i') }}
                </div>

                <div class="mb-4 text-sm text-gray-600">
                  <strong>Lokasi:</strong> {{ $event->location }}
                </div>

                <p class="mb-4 text-sm text-gray-700">
                  {{ Str::limit($event->description, 100) }}
                </p>

                <a href="{{ route('event.show', $event) }}" wire:navigate
                  class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-600 disabled:opacity-25">
                  Lihat Detail
                </a>
              </div>
            </div>
          @endforeach

        </div>

        <div class="mt-8">
          {{ $events->links() }}
        </div>
      @endif

    </div>
  </div>
</div>
