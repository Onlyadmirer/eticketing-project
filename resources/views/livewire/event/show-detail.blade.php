<div>
  {{-- Kita tidak pakai header <x-slot> agar gambar bisa 'full-bleed' --}}

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">

        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->name }}" class="object-cover w-full h-96">

        <div class="p-6 md:p-8">
          <h1 class="mb-4 text-3xl font-bold text-gray-900">
            {{ $event->name }}
          </h1>

          <div class="flex flex-wrap gap-4 mb-6 text-gray-600">
            <div class="flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              <span>{{ \Carbon\Carbon::parse($event->event_time)->format('D, d M Y - H:i') }} WIB</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
              <span>{{ $event->location }}</span>
            </div>
          </div>

          <h2 class="mb-3 text-2xl font-semibold text-gray-800">Deskripsi Acara</h2>
          <p class="mb-8 leading-relaxed text-gray-700">
            {!! nl2br(e($event->description)) !!}
          </p>

          <hr class="my-8">

          <h2 class="mb-4 text-2xl font-semibold text-gray-800">Tiket</h2>

          @if ($event->tickets->isEmpty())
            <p class="text-gray-600">Tiket untuk acara ini belum tersedia.</p>
          @else
            <div class="space-y-4">
              @foreach ($event->tickets as $ticket)
                <div
                  class="flex flex-col items-start justify-between p-4 border rounded-lg shadow-sm md:flex-row md:items-center">
                  <div>
                    <h3 class="text-lg font-semibold">{{ $ticket->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $ticket->description }}</p>
                    <div class="mt-1 text-lg font-bold text-indigo-600">
                      Rp {{ number_format($ticket->price, 0, ',', '.') }}
                    </div>
                  </div>
                  <div class="mt-4 md:mt-0 md:text-right">
                    <div class="mb-2 text-sm text-gray-700">
                      Sisa Kuota: <strong>{{ $ticket->quantity }}</strong>
                    </div>
                    <a href="#"
                      class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 ... transition">
                      Pesan Tiket
                    </a>
                  </div>
                  V
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
