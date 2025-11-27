<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-white">
      Manajemen Tiket: <span class="text-lime-400">{{ $event->title }}</span>
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

      <div class="flex items-center justify-between mb-6">
        <a href="{{ Auth::user()->role === 'admin' ? route('admin.events.index') : route('organizer.events.index') }}"
          class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-gray-300 transition border border-gray-600 rounded-lg hover:bg-gray-800 hover:text-white">
          &larr; Kembali ke Event
        </a>

        <a href="{{ Auth::user()->role === 'admin' ? route('admin.events.tickets.create', $event->id) : route('organizer.events.tickets.create', $event->id) }}"
          class="inline-flex items-center px-4 py-2 text-xs font-bold tracking-widest text-black uppercase transition duration-150 ease-in-out border border-transparent rounded-lg shadow-lg bg-lime-400 hover:bg-lime-500 focus:bg-lime-500 active:bg-lime-600 focus:outline-none focus:ring-2 focus:ring-lime-500 focus:ring-offset-2 focus:ring-offset-gray-800 shadow-lime-400/20">
          + Tambah Tiket Baru
        </a>
      </div>

      @if (session('success'))
        <div class="relative px-4 py-3 mb-6 text-green-300 border border-green-600 rounded bg-green-900/50">
          {{ session('success') }}
        </div>
      @endif

      <div class="bg-[#27272a] border border-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 text-gray-100">

          @if ($tickets->count() > 0)
            <div class="overflow-x-auto">
              <table class="min-w-full border border-collapse border-gray-700 table-auto">
                <thead>
                  <tr class="text-xs font-bold tracking-wider text-left text-gray-300 uppercase bg-black/30">
                    <th class="px-4 py-3 border border-gray-700">Nama Tiket</th>
                    <th class="px-4 py-3 border border-gray-700">Harga</th>
                    <th class="px-4 py-3 text-center border border-gray-700">Kuota</th>
                    <th class="px-4 py-3 border border-gray-700">Deskripsi</th>
                    <th class="px-4 py-3 text-center border border-gray-700">Aksi</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                  @foreach ($tickets as $ticket)
                    <tr class="transition duration-150 hover:bg-white/5">
                      <td class="px-4 py-3 font-bold text-white border border-gray-700">
                        {{ $ticket->name }}
                      </td>
                      <td class="px-4 py-3 font-bold border border-gray-700 text-lime-400">
                        Rp {{ number_format($ticket->price, 0, ',', '.') }}
                      </td>
                      <td class="px-4 py-3 text-center border border-gray-700">
                        <span class="px-2 py-1 text-xs font-bold text-white bg-gray-700 border border-gray-600 rounded">
                          {{ $ticket->quota }}
                        </span>
                      </td>
                      <td class="px-4 py-3 text-sm text-gray-300 border border-gray-700">
                        {{ $ticket->description ?? '-' }}
                      </td>
                      <td class="px-4 py-3 text-center border border-gray-700">
                        <form
                          action="{{ Auth::user()->role === 'admin' ? route('admin.tickets.destroy', $ticket->id) : route('organizer.tickets.destroy', $ticket->id) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus tiket ini? Data booking terkait juga mungkin akan terhapus.')">
                          @csrf
                          @method('DELETE')
                          <button type="submit"
                            class="flex items-center justify-center gap-1 mx-auto text-sm font-bold text-red-500 hover:text-red-400 hover:underline">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                              stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            Hapus
                          </button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="py-10 text-center border border-gray-700 border-dashed rounded bg-black/20">
              <div
                class="inline-flex items-center justify-center w-12 h-12 mb-3 text-gray-500 bg-gray-800 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v9.652a1.125 1.125 0 0 0 .621 1.096l2.64 1.433a1.125 1.125 0 0 1 .589 1.014v.825c0 .621.504 1.125 1.125 1.125h10.5c.621 0 1.125-.504 1.125-1.125v-.825a1.125 1.125 0 0 1 .589-1.014l2.64-1.433a1.125 1.125 0 0 0 .621-1.096V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                </svg>
              </div>
              <p class="text-gray-500">Belum ada tiket untuk event ini.</p>
              <p class="mt-1 text-xs text-gray-600">Klik tombol "+ Tambah Tiket Baru" untuk mulai menjual tiket.</p>
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
