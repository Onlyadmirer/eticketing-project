<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Edit Event') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">

          <form
            action="{{ Auth::user()->role === 'admin' ? route('admin.events.update', $event->id) : route('organizer.events.update', $event->id) }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="mb-4">
              <label class="block mb-2 text-sm font-bold text-gray-700">Nama Event</label>
              <input type="text" name="title" value="{{ old('title', $event->title) }}"
                class="w-full px-3 py-2 border rounded" required>
            </div>

            <div class="mb-4">
              <label class="block mb-2 text-sm font-bold text-gray-700">Deskripsi</label>
              <textarea name="description" class="w-full px-3 py-2 border rounded" rows="4" required>{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="mb-4">
              <label class="block mb-2 text-sm font-bold text-gray-700">Tanggal & Waktu</label>
              <input type="datetime-local" name="start_time" value="{{ old('start_time', $event->start_time) }}"
                class="w-full px-3 py-2 border rounded" required>
            </div>

            <div class="mb-4">
              <label class="block mb-2 text-sm font-bold text-gray-700">Lokasi</label>
              <input type="text" name="location" value="{{ old('location', $event->location) }}"
                class="w-full px-3 py-2 border rounded" required>
            </div>

            <div class="mb-4">
              <label class="block mb-2 text-sm font-bold text-gray-700">Poster Event (Opsional)</label>
              @if ($event->image)
                <div class="mb-2">
                  <img src="{{ asset('storage/' . $event->image) }}" class="w-32 h-auto rounded">
                  <p class="text-xs text-gray-500">Gambar saat ini</p>
                </div>
              @endif
              <input type="file" name="image" class="w-full px-3 py-2 border rounded">
              <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengganti gambar.</p>
            </div>

            <div class="flex gap-2">
              <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700">
                Update Event
              </button>
              <a href="{{ Auth::user()->role === 'admin' ? route('admin.events.index') : route('organizer.events.index') }}"
                class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-700">
                Batal
              </a>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
