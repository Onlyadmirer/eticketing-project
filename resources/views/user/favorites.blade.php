<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-white">
      {{ __('Event Favorit Saya') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

      @if ($favorites->count() > 0)
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
          @foreach ($favorites as $fav)
            <div
              class="group bg-[#27272a] rounded-2xl overflow-hidden border border-gray-800 hover:border-red-500/50 transition-all duration-300 shadow-lg relative flex flex-col">

              <form action="{{ route('user.favorites.toggle', $fav->event->id) }}" method="POST"
                class="absolute z-20 top-3 right-3">
                @csrf
                <button type="submit"
                  class="p-2 text-white transition rounded-full bg-black/50 hover:bg-red-600 backdrop-blur-sm"
                  title="Hapus dari Favorit">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                      d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                      clip-rule="evenodd" />
                  </svg>
                </button>
              </form>

              <a href="{{ route('event.detail', ['id' => $fav->event->id, 'from' => 'favorites']) }}"
                class="flex-1 block">
                <div class="relative h-48 overflow-hidden">
                  @if ($fav->event->image)
                    <img src="{{ asset('storage/' . $fav->event->image) }}"
                      class="object-cover w-full h-full transition opacity-80 group-hover:opacity-100">
                  @else
                    <div class="flex items-center justify-center w-full h-full text-gray-500 bg-gray-800">No Image</div>
                  @endif
                </div>
                <div class="p-5">
                  <h3 class="mb-1 text-lg font-bold text-white transition group-hover:text-red-400">
                    {{ $fav->event->title }}</h3>
                  <p class="text-sm text-gray-400">{{ \Carbon\Carbon::parse($fav->event->start_time)->format('d M Y') }}
                  </p>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      @else
        <div class="text-center py-12 bg-[#27272a] rounded-xl border border-dashed border-gray-700">
          <div class="inline-flex items-center justify-center w-16 h-16 mb-4 text-gray-500 bg-gray-800 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-8 h-8">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
            </svg>
          </div>
          <h3 class="mb-2 text-xl font-bold text-white">Belum ada Favorit</h3>
          <p class="mb-6 text-gray-400">Simpan event yang Anda sukai agar mudah ditemukan nanti.</p>
          <a href="/"
            class="px-6 py-2 font-bold text-black transition bg-white rounded-full hover:bg-gray-200">Cari Event</a>
        </div>
      @endif

    </div>
  </div>
</x-app-layout>
