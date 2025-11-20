<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Manage Users') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

      @if (session('success'))
        <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
          <span class="block sm:inline">{{ session('success') }}</span>
        </div>
      @endif

      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 overflow-x-auto text-gray-900">

          <table class="min-w-full border border-collapse border-gray-200 table-auto">
            <thead>
              <tr class="bg-gray-100">
                <th class="px-4 py-2 border">Nama</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">Role</th>
                <th class="px-4 py-2 border">Status Organizer</th>
                <th class="px-4 py-2 border">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
                <tr class="text-center">
                  <td class="px-4 py-2 border">{{ $user->name }}</td>
                  <td class="px-4 py-2 border">{{ $user->email }}</td>
                  <td class="px-4 py-2 capitalize border">{{ $user->role }}</td>
                  <td class="px-4 py-2 border">
                    @if ($user->role === 'organizer')
                      <span
                        class="px-2 py-1 rounded text-white text-xs
                                            {{ $user->organizer_status === 'approved'
                                                ? 'bg-green-500'
                                                : ($user->organizer_status === 'rejected'
                                                    ? 'bg-red-500'
                                                    : 'bg-yellow-500') }}">
                        {{ ucfirst($user->organizer_status) }}
                      </span>
                    @else
                      -
                    @endif
                  </td>
                  <td class="px-4 py-2 border">
                    @if ($user->role === 'organizer')
                      <div class="flex justify-center gap-2">
                        <form action="{{ route('admin.users.verify', $user->id) }}" method="POST">
                          @csrf
                          @method('PATCH')
                          <input type="hidden" name="organizer_status" value="approved">
                          <button type="submit"
                            class="px-3 py-1 text-xs font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                            Approve
                          </button>
                        </form>

                        <form action="{{ route('admin.users.verify', $user->id) }}" method="POST">
                          @csrf
                          @method('PATCH')
                          <input type="hidden" name="organizer_status" value="rejected">
                          <button type="submit"
                            class="px-3 py-1 text-xs font-bold text-white bg-gray-500 rounded hover:bg-gray-700">
                            Reject
                          </button>
                        </form>
                      </div>
                    @endif

                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                      class="inline-block mt-2" onsubmit="return confirm('Yakin hapus user ini?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-xs text-red-600 underline hover:text-red-900">
                        Hapus
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
