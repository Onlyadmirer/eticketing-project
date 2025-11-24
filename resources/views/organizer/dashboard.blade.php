<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Organizer Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h3 class="mb-4 text-lg font-bold">Selamat Datang, Organizer!</h3>
          <p class="mb-6 text-gray-600">
            Ini adalah area kerja Anda. Di sini Anda dapat membuat acara baru, mengatur tiket, dan melihat laporan
            pengunjung.
          </p>

          <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            <a href="{{ route('organizer.events.index') }}"
              class="block p-6 transition border border-indigo-200 rounded-lg bg-indigo-50 hover:shadow-md hover:bg-indigo-100 group">
              <div class="flex items-center gap-4">
                <div class="p-3 text-white transition bg-indigo-500 rounded-full group-hover:bg-indigo-600">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                  </svg>
                </div>
                <div>
                  <h4 class="text-lg font-bold text-indigo-900">Kelola Event & Tiket</h4>
                  <p class="text-sm text-indigo-700">Buat acara baru atau update tiket.</p>
                </div>
              </div>
            </a>

            <div class="block p-6 border border-green-200 rounded-lg bg-green-50">
              <div class="flex items-center gap-4">
                <div class="p-3 text-white bg-green-500 rounded-full">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                  </svg>
                </div>
                <div>
                  <h4 class="text-lg font-bold text-green-900">Laporan Penjualan</h4>
                  <p class="text-sm text-green-700">
                    Masuk ke menu <span class="font-semibold">My Events</span>, lalu klik tombol <span
                      class="font-semibold">👥 Lihat Peserta</span>.
                  </p>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
