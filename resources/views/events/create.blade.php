<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-white">
      {{ __('Buat Event Baru') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

      @if ($errors->any())
        <div class="p-4 mb-6 border-l-4 border-red-500 rounded-lg bg-red-500/10">
          <div class="flex items-start">
            <div class="flex-shrink-0">
              <svg class="w-5 h-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                  clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-bold text-red-400">Gagal membuat event!</h3>
              <div class="mt-2 text-sm text-red-300">
                <ul class="pl-5 space-y-1 list-disc">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        </div>
      @endif

      <div class="bg-[#27272a] border border-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-8 text-gray-100">

          <div class="pb-4 mb-6 border-b border-gray-700">
            <h3 class="text-lg font-bold text-lime-400">Detail Acara</h3>
            <p class="text-sm text-gray-300">Isi informasi lengkap mengenai event yang akan Anda selenggarakan.</p>
          </div>

          <form
            action="{{ Auth::user()->role === 'admin' ? route('admin.events.store') : route('organizer.events.store') }}"
            method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
              <label class="block mb-2 text-sm font-bold text-gray-300">Nama Event</label>
              <input type="text" name="title" required
                class="w-full px-4 py-3 text-white placeholder-gray-500 transition border border-gray-700 rounded-lg bg-black/20 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400"
                placeholder="Contoh: Konser Musik Amal 2025">
            </div>

            <div>
              <label class="block mb-2 text-sm font-bold text-gray-300">Kategori Event</label>
              <select name="category" required
                class="w-full px-4 py-3 text-white transition border border-gray-700 rounded-lg bg-black/20 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400">
                <option value="" disabled selected>Pilih Kategori...</option>
                <option value="Konser Musik">Konser Musik</option>
                <option value="Seminar">Seminar / Workshop</option>
                <option value="Olahraga">Olahraga</option>
                <option value="Pameran">Pameran / Expo</option>
                <option value="Teater">Teater / Seni</option>
                <option value="Lainnya">Lainnya</option>
              </select>
            </div>
            <div>
              <label class="block mb-2 text-sm font-bold text-gray-300">Deskripsi</label>
              <textarea name="description" rows="5" required
                class="w-full px-4 py-3 text-white placeholder-gray-500 transition border border-gray-700 rounded-lg bg-black/20 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400"
                placeholder="Jelaskan detail acara, bintang tamu, atau rundown singkat..."></textarea>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <div>
                <label class="block mb-2 text-sm font-bold text-gray-300">Tanggal & Waktu</label>
                <input type="datetime-local" name="start_time" required
                  class="w-full bg-black/20 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 placeholder-gray-500 transition [color-scheme:dark]">
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
                  <input type="text" name="location" required
                    class="w-full py-3 pl-10 pr-4 text-white placeholder-gray-500 transition border border-gray-700 rounded-lg bg-black/20 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400"
                    placeholder="Nama Gedung / Kota">
                </div>
              </div>
            </div>

            <div>
              <label class="block mb-2 text-sm font-bold text-gray-300">Poster Event</label>
              <input type="file" name="image"
                class="block w-full p-2 text-sm text-gray-400 transition border border-gray-700 rounded-lg cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-lime-400 file:text-black hover:file:bg-lime-500 bg-black/20 focus:outline-none focus:border-lime-400">
              <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Max: 2MB.</p>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-700">
              <a href="{{ url()->previous() }}"
                class="px-6 py-3 font-medium text-gray-400 transition rounded-lg hover:text-white hover:bg-gray-800">
                Batal
              </a>

              <button type="submit"
                class="px-6 py-3 font-bold text-black transition transform rounded-lg shadow-lg bg-lime-400 hover:bg-lime-500 shadow-lime-400/20 ">
                Simpan Event
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
