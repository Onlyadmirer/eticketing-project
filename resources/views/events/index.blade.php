<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-white">
      {{ __('Daftar Event Saya') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

      <div class="mb-6">
        <a href="{{ Auth::user()->role === 'admin' ? route('admin.events.create') : route('organizer.events.create') }}"
          class="inline-flex items-center px-4 py-2 text-xs font-bold tracking-widest text-black uppercase transition duration-150 ease-in-out border border-transparent rounded-md shadow-lg bg-lime-400 hover:bg-lime-500 focus:bg-lime-500 active:bg-lime-600 focus:outline-none focus:ring-2 focus:ring-lime-500 focus:ring-offset-2 focus:ring-offset-gray-800 shadow-lime-400/20">
          + Buat Event Baru
        </a>
      </div>

      @if (session('success'))
        <div class="relative px-4 py-3 mb-6 text-green-300 border border-green-600 rounded bg-green-900/50">
          {{ session('success') }}
        </div>
      @endif

      <div class="bg-[#27272a] border border-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 text-gray-100">

          <div class="overflow-x-auto">
            <table class="min-w-full border border-collapse table-auto border-lime-300">
              <thead>
                <tr class="text-xs font-bold tracking-wider text-left text-gray-300 uppercase bg-black/30">
                  <th class="px-4 py-3 border border-gray-500">Poster</th>
                  <th class="px-4 py-3 border border-gray-500">Nama Event</th>
                  <th class="px-4 py-3 border border-gray-500">Waktu</th>
                  <th class="px-4 py-3 border border-gray-500">Lokasi</th>
                  <th class="px-4 py-3 text-center border border-gray-500">Aksi</th>
                  <thead>
                  </thead>
              <tbody class="divide-y divide-gray-700">
                @foreach ($events as $event)
                  <tr class="transition duration-150 hover:bg-white/5">
                    <td class="px-4 py-3 border border-gray-500">
                      @if ($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}"
                          class="object-cover w-20 border border-gray-600 rounded shadow-sm h-14">
                      @else
                        <div
                          class="flex items-center justify-center w-20 text-xs text-gray-500 bg-gray-800 border border-gray-500 rounded h-14">
                          No Img
                        </div>
                      @endif
                    </td>
                    <td class="px-4 py-3 font-bold text-white border border-gray-500">
                      {{ $event->title }}
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-300 border border-gray-500">
                      {{ \Carbon\Carbon::parse($event->start_time)->format('d M Y, H:i') }}
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-300 border border-gray-500">
                      {{ $event->location }}
                    </td>
                    <td class="px-4 py-3 border border-gray-500">
                      <div class="flex flex-col items-center gap-2">

                        <div class="flex gap-2">
                          <a href="{{ Auth::user()->role === 'admin' ? route('admin.events.tickets.index', $event->id) : route('organizer.events.tickets.index', $event->id) }}"
                            class="px-2 py-1 text-xs font-bold text-indigo-300 transition border border-indigo-700 rounded bg-indigo-900/50 hover:bg-indigo-800">
                            🎫 Tiket
                          </a>

                          <a href="{{ Auth::user()->role === 'admin' ? route('admin.events.bookings', $event->id) : route('organizer.events.bookings', $event->id) }}"
                            class="px-2 py-1 text-xs font-bold transition border rounded bg-emerald-900/50 text-emerald-300 border-emerald-700 hover:bg-emerald-800">
                            🙍‍♂️ Peserta
                          </a>
                        </div>

                        <div class="flex items-center gap-3 mt-1 text-xs">
                          <a href="{{ Auth::user()->role === 'admin' ? route('admin.events.edit', $event->id) : route('organizer.events.edit', $event->id) }}"
                            class="font-bold text-yellow-500 hover:text-yellow-400 hover:underline">
                            Edit
                          </a>

                          <span class="text-gray-600">|</span>

                          <button type="button"
                            onclick="confirmDelete('{{ Auth::user()->role === 'admin' ? route('admin.events.destroy', $event->id) : route('organizer.events.destroy', $event->id) }}')"
                            class="font-bold text-red-500 hover:text-red-400 hover:underline">
                            Hapus
                          </button>
                        </div>

                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          @if ($events->isEmpty())
            <div class="py-10 text-center">
              <p class="text-gray-500">Anda belum membuat event apapun.</p>
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>
  <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 transition-opacity bg-black/80 backdrop-blur-sm" aria-hidden="true"></div>

      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div
        class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-[#27272a] border border-gray-700 rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div
              class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto rounded-full bg-red-900/30 sm:mx-0 sm:h-10 sm:w-10">
              <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
              </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3 class="text-lg font-bold leading-6 text-white" id="modal-title">Hapus Event?</h3>
              <div class="mt-2">
                <p class="text-sm text-gray-400">
                  Apakah Anda yakin ingin menghapus event ini? <br>
                  <span class="font-semibold text-red-400">Tindakan ini tidak dapat dibatalkan</span> dan semua data
                  tiket terkait akan hilang.
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="gap-2 px-4 py-3 bg-black/20 sm:px-6 sm:flex sm:flex-row-reverse">

          <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <button type="submit"
              class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white transition bg-red-600 border border-transparent rounded-lg shadow-sm hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
              Ya, Hapus
            </button>
          </form>

          <button type="button" onclick="closeModal()"
            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-300 transition bg-gray-800 border border-gray-600 rounded-lg shadow-sm hover:bg-gray-700 hover:text-white focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            Batal
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function confirmDelete(actionUrl) {
      document.getElementById('deleteForm').action = actionUrl;
      document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeModal() {
      document.getElementById('deleteModal').classList.add('hidden');
    }
  </script>
</x-app-layout>
