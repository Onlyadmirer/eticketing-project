<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      Tambah Tiket untuk: {{ $event->title }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">

          <form
            action="{{ Auth::user()->role === 'admin' ? route('admin.events.tickets.store', $event->id) : route('organizer.events.tickets.store', $event->id) }}"
            method="POST">
            @csrf

            <div class="mb-4">
              <label class="block mb-2 text-sm font-bold text-gray-700">Nama Tiket (Misal: VIP)</label>
              <input type="text" name="name" class="w-full px-3 py-2 border rounded" required
                placeholder="VIP / Regular / Early Bird">
            </div>

            <div class="mb-4">
              <label class="block mb-2 text-sm font-bold text-gray-700">Harga (Rp)</label>
              <input type="number" name="price" class="w-full px-3 py-2 border rounded" required min="0">
            </div>

            <div class="mb-4">
              <label class="block mb-2 text-sm font-bold text-gray-700">Jumlah Kuota</label>
              <input type="number" name="quota" class="w-full px-3 py-2 border rounded" required min="1">
            </div>

            <div class="mb-4">
              <label class="block mb-2 text-sm font-bold text-gray-700">Deskripsi / Fasilitas (Opsional)</label>
              <textarea name="description" class="w-full px-3 py-2 border rounded" rows="3"></textarea>
            </div>

            <div class="flex gap-2">
              <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700">
                Simpan Tiket
              </button>
              <a href="{{ url()->previous() }}" class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-700">
                Batal
              </a>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
