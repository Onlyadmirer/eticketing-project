<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Buat Event Baru') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">

          <form
            action="{{ Auth::user()->role === 'admin' ? route('admin.events.store') : route('organizer.events.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
              <label class="block mb-2 text-sm font-bold text-gray-700">Nama Event</label>
              <input type="text" name="title" class="w-full px-3 py-2 border rounded" required>
            </div>

            <div class="mb-4">
              <label class="block mb-2 text-sm font-bold text-gray-700">Deskripsi</label>
              <textarea name="description" class="w-full px-3 py-2 border rounded" rows="4" required></textarea>
            </div>

            <div class="mb-4">
              <label class="block mb-2 text-sm font-bold text-gray-700">Tanggal & Waktu</label>
              <input type="datetime-local" name="start_time" class="w-full px-3 py-2 border rounded" required>
            </div>

            <div class="mb-4">
              <label class="block mb-2 text-sm font-bold text-gray-700">Lokasi</label>
              <input type="text" name="location" class="w-full px-3 py-2 border rounded" required>
            </div>

            <div class="mb-4">
              <label class="block mb-2 text-sm font-bold text-gray-700">Poster Event</label>
              <input type="file" name="image" class="w-full px-3 py-2 border rounded">
            </div>

            <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700">
              Simpan Event
            </button>
          </form>

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
