<div>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Edit Acara: ') }} {{ $name }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">

          <form wire:submit="update">

            <div>
              <x-input-label for="name" :value="__('Nama Acara')" />
              <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" />
              <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
              <x-input-label for="description" :value="__('Deskripsi')" />
              <textarea wire:model="description" id="description" rows="5"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
              <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="mt-4">
              <x-input-label for="event_time" :value="__('Tanggal & Waktu')" />
              <x-text-input wire:model="event_time" id="event_time" class="block mt-1 w-full" type="datetime-local" />
              <x-input-error :messages="$errors->get('event_time')" class="mt-2" />
            </div>

            <div class="mt-4">
              <x-input-label for="location" :value="__('Lokasi')" />
              <x-text-input wire:model="location" id="location" class="block mt-1 w-full" type="text" />
              <x-input-error :messages="$errors->get('location')" class="mt-2" />
            </div>

            <div class="mt-4">
              <x-input-label for="new_image" :value="__('Ganti Gambar Acara (Opsional)')" />
              <x-text-input wire:model="new_image" id="new_image" class="block mt-1 w-full" type="file" />

              <div wire:loading wire:target="new_image" class="text-sm text-gray-500 mt-1">Uploading...</div>

              <div class="mt-2">
                @if ($new_image)
                  <span class="text-sm text-gray-500">Preview Gambar Baru:</span>
                  <img src="{{ $new_image->temporaryUrl() }}" class="mt-1 h-32 w-auto">
                @elseif ($existing_image_path)
                  <span class="text-sm text-gray-500">Gambar Saat Ini:</span>
                  <img src="{{ asset('storage/' . $existing_image_path) }}" class="mt-1 h-32 w-auto">
                @endif
              </div>

              <x-input-error :messages="$errors->get('new_image')" class="mt-2" />
            </div>

            <div class="mt-6">
              <x-primary-button>
                {{ __('Update Acara') }}
              </x-primary-button>
            </div>
          </form>

        </div>
      </div>
    </div>
    <div class="pb-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">

            <h3 class="text-lg font-semibold mb-4">Kelola Tiket</h3>

            @if (session('success_ticket'))
              <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success_ticket') }}
              </div>
            @endif

            <form wire:submit="addTicket" class="mb-6 p-4 border rounded-md">
              <h4 class="text-md font-medium mb-3">Tambah Tiket Baru</h4>
              <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                  <x-input-label for="ticket_name" :value="__('Nama Tiket (cth: VIP)')" />
                  <x-text-input wire:model="ticket_name" id="ticket_name" class="block mt-1 w-full" type="text" />
                  <x-input-error :messages="$errors->get('ticket_name')" class="mt-2" />
                </div>
                <div>
                  <x-input-label for="ticket_price" :value="__('Harga (Rp)')" />
                  <x-text-input wire:model="ticket_price" id="ticket_price" class="block mt-1 w-full" type="number"
                    min="0" />
                  <x-input-error :messages="$errors->get('ticket_price')" class="mt-2" />
                </div>
                <div>
                  <x-input-label for="ticket_quantity" :value="__('Kuota (Jumlah)')" />
                  <x-text-input wire:model="ticket_quantity" id="ticket_quantity" class="block mt-1 w-full"
                    type="number" min="1" />
                  <x-input-error :messages="$errors->get('ticket_quantity')" class="mt-2" />
                </div>
                <div class="col-span-1 md:col-span-4">
                  <x-input-label for="ticket_description" :value="__('Deskripsi (Opsional)')" />
                  <x-text-input wire:model="ticket_description" id="ticket_description" class="block mt-1 w-full"
                    type="text" />
                  <x-input-error :messages="$errors->get('ticket_description')" class="mt-2" />
                </div>
              </div>
              <x-primary-button class="mt-4">
                {{ __('Tambah Tiket') }}
              </x-primary-button>
            </form>

            <h4 class="text-md font-medium mb-3">Daftar Tiket Saat Ini</h4>
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class-="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kuota</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($event->tickets as $ticket)
                  <tr>
                    <td class="px-6 py-4">{{ $ticket->name }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($ticket->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">{{ $ticket->quantity }}</td>
                    <td class="px-6 py-4">
                      <button class="text-red-600 hover:text-red-900">Hapus</button>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                      Belum ada tiket untuk acara ini.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
