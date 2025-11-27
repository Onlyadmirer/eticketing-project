<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-white">
      Manage Users & <span class="text-lime-400">Organizer</span>
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

      @if (session('success'))
        <div class="relative px-4 py-3 mb-6 text-green-300 border border-green-600 rounded-lg bg-green-900/50"
          role="alert">
          <span class="block font-bold sm:inline">{{ session('success') }}</span>
        </div>
      @endif

      <div class="bg-[#27272a] border border-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 text-gray-100">

          <div class="overflow-x-auto">
            <table class="min-w-full border border-collapse border-gray-700 table-auto">
              <thead>
                <tr class="text-xs font-bold tracking-wider text-left text-gray-400 uppercase bg-black/30">
                  <th class="px-6 py-4 border border-gray-700">Nama Pengguna</th>
                  <th class="px-6 py-4 border border-gray-700">Email</th>
                  <th class="px-6 py-4 text-center border border-gray-700">Role</th>
                  <th class="px-6 py-4 text-center border border-gray-700">Status Organizer</th>
                  <th class="px-6 py-4 text-center border border-gray-700">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-700">
                @foreach ($users as $user)
                  <tr class="transition duration-150 hover:bg-white/5">
                    <td class="px-6 py-4 font-bold text-white border border-gray-700">
                      {{ $user->name }}
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-300 border border-gray-700">
                      {{ $user->email }}
                    </td>

                    <td class="px-6 py-4 text-center border border-gray-700">
                      @if ($user->role === 'admin')
                        <span
                          class="px-3 py-1 text-xs font-bold text-purple-400 border border-purple-700 rounded-full bg-purple-900/50">Admin</span>
                      @elseif($user->role === 'organizer')
                        <span
                          class="px-3 py-1 text-xs font-bold border rounded-full bg-lime-900/50 text-lime-400 border-lime-700">Organizer</span>
                      @else
                        <span
                          class="px-3 py-1 text-xs font-bold text-blue-400 border border-blue-700 rounded-full bg-blue-900/50">User</span>
                      @endif
                    </td>

                    <td class="px-6 py-4 text-center border border-gray-700">
                      @if ($user->role === 'organizer')
                        <span
                          class="px-3 py-1 rounded-full text-xs font-bold border
                                                    {{ $user->organizer_status === 'approved'
                                                        ? 'bg-green-900/50 text-green-400 border-green-700'
                                                        : ($user->organizer_status === 'rejected'
                                                            ? 'bg-red-900/50 text-red-400 border-red-700'
                                                            : 'bg-yellow-900/50 text-yellow-400 border-yellow-700 animate-pulse') }}">
                          {{ ucfirst($user->organizer_status) }}
                        </span>
                      @else
                        <span class="text-gray-600">-</span>
                      @endif
                    </td>

                    <td class="px-6 py-4 text-center border border-gray-700">
                      <div class="flex flex-col items-center gap-2">

                        @if ($user->role === 'organizer' && $user->organizer_status === 'pending')
                          <div class="flex gap-2 mb-1">
                            <form action="{{ route('admin.users.verify', $user->id) }}" method="POST">
                              @csrf
                              @method('PATCH')
                              <input type="hidden" name="organizer_status" value="approved">
                              <button type="submit"
                                class="p-1 text-white transition bg-green-600 rounded hover:bg-green-500"
                                title="Approve">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                  stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                              </button>
                            </form>

                            <form action="{{ route('admin.users.verify', $user->id) }}" method="POST">
                              @csrf
                              @method('PATCH')
                              <input type="hidden" name="organizer_status" value="rejected">
                              <button type="submit"
                                class="p-1 text-white transition bg-red-600 rounded hover:bg-red-500" title="Reject">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                  stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                              </button>
                            </form>
                          </div>
                        @endif

                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                          onsubmit="return confirm('Yakin hapus user ini?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit"
                            class="flex items-center gap-1 text-xs font-bold text-red-500 hover:text-red-400 hover:underline">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                              stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            Hapus
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
