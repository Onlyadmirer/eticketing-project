<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Manage Users') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
          <span class="block sm:inline">{{ session('success') }}</span>
        </div>
      @endif

      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 overflow-x-auto">

          <table class="min-w-full table-auto border-collapse border border-gray-200">
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
                  <td class="px-4 py-2 border capitalize">{{ $user->role }}</td>
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
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs">
                            Approve
                          </button>
                        </form>

                        <form action="{{ route('admin.users.verify', $user->id) }}" method="POST">
                          @csrf
                          @method('PATCH')
                          <input type="hidden" name="organizer_status" value="rejected">
                          <button type="submit"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-3 rounded text-xs">
                            Reject
                          </button>
                        </form>
                      </div>
                    @endif

                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                      class="mt-2 inline-block" onsubmit="return confirm('Yakin hapus user ini?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-red-600 hover:text-red-900 text-xs underline">
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
