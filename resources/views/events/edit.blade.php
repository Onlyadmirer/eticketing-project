<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-white">
      Edit Event: <span class="text-lime-400">{{ $event->title }}</span>
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

      <div class="bg-[#27272a] border border-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-8 text-gray-100">

          <div class="flex items-center justify-between pb-4 mb-6 border-b border-gray-700">
            <div>
              <h3 class="text-lg font-bold text-lime-400">Perbarui Informasi</h3>
              <p class="text-sm text-gray-400">Ubah detail acara sesuai kebutuhan.</p>
            </div>
            @if ($event->image)
              <img src="{{ asset('storage/' . $event->image) }}"
                class="object-cover w-16 h-10 border border-gray-600 rounded">
            @endif
          </div>

          <form
            action="{{ Auth::user()->role === 'admin' ? route('admin.events.update', $event->id) : route('organizer.events.update', $event->id) }}"
            method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT') <div>
              <label class="block mb-2 text-sm font-bold text-gray-300">Nama Event</label>
              <input type="text" name="title" value="{{ old('title', $event->title) }}" required
                class="w-full px-4 py-3 text-white placeholder-gray-600 transition border border-gray-700 rounded-lg bg-black/20 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400">
            </div>

            <div>
              <label class="block mb-2 text-sm font-bold text-gray-300">Kategori Event</label>
              <select name="category" required
                class="w-full px-4 py-3 text-white transition border border-gray-700 rounded-lg cursor-pointer bg-black/20 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400">
                @php
                  $categories = ['Konser Musik', 'Seminar', 'Olahraga', 'Pameran', 'Teater', 'Lainnya'];
                @endphp
                @foreach ($categories as $cat)
                  <option value="{{ $cat }}" {{ old('category', $event->category) == $cat ? 'selected' : '' }}>
                    {{ $cat }}
                  </option>
                @endforeach
              </select>
            </div>

            <div>
              <label class="block mb-2 text-sm font-bold text-gray-300">Deskripsi</label>
              <textarea name="description" rows="5" required
                class="w-full px-4 py-3 text-white placeholder-gray-600 transition border border-gray-700 rounded-lg bg-black/20 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400">{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <div>
                <label class="block mb-2 text-sm font-bold text-gray-300">Tanggal & Waktu</label>
                <input type="datetime-local" name="start_time"
                  value="{{ old('start_time', \Carbon\Carbon::parse($event->start_time)->format('Y-m-d\TH:i')) }}"
                  required
                  class="w-full bg-black/20 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 placeholder-gray-600 transition [color-scheme:dark]">
              </div>

              <div>
                <label class="block mb-2 text-sm font-bold text-gray-300">Lokasi</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" class="w-5 h-5 text-gray-500">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                  </div>
                  <input type="text" name="location" value="{{ old('location', $event->location) }}" required
                    class="w-full py-3 pl-10 pr-4 text-white placeholder-gray-600 transition border border-gray-700 rounded-lg bg-black/20 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400">
                </div>
              </div>
            </div>

            <div>
              <label class="block mb-2 text-sm font-bold text-gray-300">
                Ganti Poster Event (Opsional)
              </label>

              @if ($event->image)
                <div class="inline-block p-2 mb-3 border border-gray-700 rounded bg-black/30">
                  <p class="mb-1 text-xs text-gray-500">Gambar saat ini:</p>
                  <img src="{{ asset('storage/' . $event->image) }}" class="w-auto h-32 rounded">
                </div>
              @endif

              <input type="file" name="image"
                class="block w-full p-2 text-sm text-gray-400 transition border border-gray-700 rounded-lg cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-lime-400 file:text-black hover:file:bg-lime-500 bg-black/20 focus:outline-none focus:border-lime-400">
              <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengganti gambar.</p>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-700">
              <a href="{{ Auth::user()->role === 'admin' ? route('admin.events.index') : route('organizer.events.index') }}"
                class="px-6 py-3 font-medium text-gray-400 transition rounded-lg hover:text-white hover:bg-gray-800">
                Batal
              </a>

              <button type="submit"
                class="px-6 py-3 font-bold text-black transition transform rounded-lg shadow-lg bg-lime-400 hover:bg-lime-500 shadow-lime-400/20 hover:scale-105">
                Update Event
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
