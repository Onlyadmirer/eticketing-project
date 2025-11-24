<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-white">
      Tambah Tiket untuk: <span class="text-lime-400">{{ $event->title }}</span>
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

      <div class="bg-[#27272a] border border-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-8 text-gray-100">

          <h3 class="pb-2 mb-6 text-lg font-bold text-gray-200 border-b border-gray-700">Formulir Tiket Baru</h3>

          <form
            action="{{ Auth::user()->role === 'admin' ? route('admin.events.tickets.store', $event->id) : route('organizer.events.tickets.store', $event->id) }}"
            method="POST">
            @csrf

            <div class="mb-5">
              <label class="block mb-2 text-sm font-bold text-gray-300">Nama Tiket</label>
              <input type="text" name="name" required
                class="w-full px-4 py-3 text-white placeholder-gray-400 transition border border-gray-700 rounded-lg bg-black/20 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400"
                placeholder="Contoh: VIP, Regular, Early Bird">
            </div>

            <div class="grid grid-cols-1 gap-5 mb-5 md:grid-cols-2">
              <div>
                <label class="block mb-2 text-sm font-bold text-gray-300">Harga (Rp)</label>
                <div class="relative">
                  <input type="number" name="price" required min="0" placeholder="Rp"
                    class="w-full py-3 pr-4 text-white placeholder-gray-400 transition border border-gray-700 rounded-lg bg-black/20 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400">
                </div>
              </div>

              <div>
                <label class="block mb-2 text-sm font-bold text-gray-300">Jumlah Kuota</label>
                <input type="number" name="quota" required min="1"
                  class="w-full px-4 py-3 text-white placeholder-gray-400 transition border border-gray-700 rounded-lg bg-black/20 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400">
              </div>
            </div>

            <div class="mb-8">
              <label class="block mb-2 text-sm font-bold text-gray-300">Deskripsi / Fasilitas (Opsional)</label>
              <textarea name="description" rows="4"
                class="w-full px-4 py-3 text-white placeholder-gray-400 transition border border-gray-700 rounded-lg bg-black/20 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400"
                placeholder="Jelaskan keuntungan tiket ini..."></textarea>
            </div>

            <div class="flex items-center gap-4 pt-6 border-t border-gray-700">
              <button type="submit"
                class="px-6 py-3 font-bold text-black transition transform rounded-lg shadow-lg bg-lime-400 hover:bg-lime-500 shadow-lime-400/20 ">
                Simpan Tiket
              </button>

              <a href="{{ url()->previous() }}"
                class="px-6 py-3 font-medium text-gray-300 transition rounded-lg hover:text-white hover:bg-gray-600">
                Batal
              </a>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
