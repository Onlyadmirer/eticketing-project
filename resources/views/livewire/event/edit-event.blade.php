<div>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Edit Acara: ') }} {{ $name }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">

          <form wire:submit="update">

            <div>
              <x-input-label for="name" :value="__('Nama Acara')" />
              <x-text-input wire:model="name" id="name" class="block w-full mt-1" type="text" />
              <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
              <x-input-label for="description" :value="__('Deskripsi')" />
              <textarea wire:model="description" id="description" rows="5"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
              <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="mt-4">
              <x-input-label for="event_time" :value="__('Tanggal & Waktu')" />
              <x-text-input wire:model="event_time" id="event_time" class="block w-full mt-1" type="datetime-local" />
              <x-input-error :messages="$errors->get('event_time')" class="mt-2" />
            </div>

            <div class="mt-4">
              <x-input-label for="location" :value="__('Lokasi')" />
              <x-text-input wire:model="location" id="location" class="block w-full mt-1" type="text" />
              <x-input-error :messages="$errors->get('location')" class="mt-2" />
            </div>

            <div class="mt-4">
              <x-input-label for="new_image" :value="__('Ganti Gambar Acara (Opsional)')" />
              <x-text-input wire:model="new_image" id="new_image" class="block w-full mt-1" type="file" />

              <div wire:loading wire:target="new_image" class="mt-1 text-sm text-gray-500">Uploading...</div>

              <div class="mt-2">
                @if ($new_image)
                  <span class="text-sm text-gray-500">Preview Gambar Baru:</span>
                  <img src="{{ $new_image->temporaryUrl() }}" class="w-auto h-32 mt-1">
                @elseif ($existing_image_path)
                  <span class="text-sm text-gray-500">Gambar Saat Ini:</span>
                  <img src="{{ asset('storage/' . $existing_image_path) }}" class="w-auto h-32 mt-1">
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
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">

            <h3 class="mb-4 text-lg font-semibold">Kelola Tiket</h3>

            @if (session('success_ticket'))
              <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
                {{ session('success_ticket') }}
              </div>
            @endif

            <form wire:submit="addTicket" class="p-4 mb-6 border rounded-md">
              <h4 class="mb-3 font-medium text-md">Tambah Tiket Baru</h4>
              <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <div>
                  <x-input-label for="ticket_name" :value="__('Nama Tiket (cth: VIP)')" />
                  <x-text-input wire:model="ticket_name" id="ticket_name" class="block w-full mt-1" type="text" />
                  <x-input-error :messages="$errors->get('ticket_name')" class="mt-2" />
                </div>
                <div>
                  <x-input-label for="ticket_price" :value="__('Harga (Rp)')" />
                  <x-text-input wire:model="ticket_price" id="ticket_price" class="block w-full mt-1" type="number"
                    min="0" />
                  <x-input-error :messages="$errors->get('ticket_price')" class="mt-2" />
                </div>
                <div>
                  <x-input-label for="ticket_quantity" :value="__('Kuota (Jumlah)')" />
                  <x-text-input wire:model="ticket_quantity" id="ticket_quantity" class="block w-full mt-1"
                    type="number" min="1" />
                  <x-input-error :messages="$errors->get('ticket_quantity')" class="mt-2" />
                </div>
                <div class="col-span-1 md:col-span-4">
                  <x-input-label for="ticket_description" :value="__('Deskripsi (Opsional)')" />
                  <x-text-input wire:model="ticket_description" id="ticket_description" class="block w-full mt-1"
                    type="text" />
                  <x-input-error :messages="$errors->get('ticket_description')" class="mt-2" />
                </div>
              </div>
              <x-primary-button class="mt-4">
                {{ __('Tambah Tiket') }}
              </x-primary-button>
            </form>

            <h4 class="mb-3 font-medium text-md">Daftar Tiket Saat Ini</h4>
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class-="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                  <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Harga</th>
                  <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Kuota</th>
                  <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Aksi</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($event->tickets as $ticket)
                  <tr>
                    <td class="px-6 py-4">{{ $ticket->name }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($ticket->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">{{ $ticket->quantity }}</td>
                    <td class="px-6 py-4">
                      <button wire:click="deleteTicket({{ $ticket->id }})"
                        wire:confirm="Anda yakin ingin menghapus tiket '{{ $ticket->name }}'?"
                        class="text-red-600 hover:text-red-900">
                        Hapus
                      </button>
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
