<div>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Create new Event') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">

          <form wire:submit="save">

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
              <x-input-label for="image" :value="__('Gambar Acara')" />
              <x-text-input wire:model="image" id="image" class="block mt-1 w-full" type="file" />

              <div wire:loading wire:target="image" class="text-sm text-gray-500 mt-1">Uploading...</div>

              @if ($image)
                <div class="mt-2">
                  <span class="text-sm text-gray-500">Preview:</span>
                  <img src="{{ $image->temporaryUrl() }}" class="mt-1 h-32 w-auto">
                </div>
              @endif

              <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            <div class="mt-6">
              <x-primary-button>
                {{ __('Simpan Acara') }}
              </x-primary-button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
