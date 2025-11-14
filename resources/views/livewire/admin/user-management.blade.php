<div>
  {{-- Kita letakkan di dalam layout standar Breeze --}}
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('User Management') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">

          {{-- Tabel Data --}}
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                  Organizer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach ($users as $user)
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ $user->role }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    {{ $user->organizer_status ?? '-' }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    {{-- Tampilkan tombol HANYA jika rolenya organizer & statusnya pending --}}
                    @if ($user->isOrganizer() && $user->organizer_status === 'pending')
                      <button wire:click="approve({{ $user->id }})"
                        class="px-2 py-1  text-green-500 rounded-lg border bg-neutral-100">
                        Approve
                      </button>
                      <button wire:click="reject({{ $user->id }})"
                        class="px-2 py-1  text-red-500 rounded-lg border bg-neutral-100">
                        Reject
                      </button>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          {{-- Link Pagination --}}
          <div class="mt-4">
            {{ $users->links() }}
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
