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

                        <button type="button"
                          onclick="openDeleteModal('{{ route('admin.users.destroy', $user->id) }}', '{{ $user->name }}')"
                          class="flex items-center gap-1 text-xs font-bold text-red-500 hover:text-red-400 hover:underline">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                              d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                          </svg>
                          Hapus
                        </button>

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

  <div id="deleteUserModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 transition-opacity bg-black/80 backdrop-blur-sm" aria-hidden="true"
        onclick="closeDeleteModal()"></div>
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
            <div class="w-full mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3 class="text-lg font-bold leading-6 text-white" id="modal-title">Hapus Pengguna?</h3>
              <div class="mt-2">
                <p class="text-sm text-gray-400">
                  Anda akan menghapus user: <br>
                  <span class="text-lg font-bold text-white" id="userNameToDelete">-</span>
                </p>
                <p class="p-2 mt-3 text-xs font-semibold text-red-400 border rounded bg-red-900/20 border-red-900/50">
                  PERINGATAN: Semua data event, tiket, dan riwayat pesanan user ini akan ikut terhapus permanen!
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="gap-2 px-4 py-3 bg-black/20 sm:px-6 sm:flex sm:flex-row-reverse">
          <form id="deleteUserForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <button type="submit"
              class="inline-flex justify-center w-full px-4 py-2 text-base font-bold text-white transition bg-red-600 border border-transparent rounded-lg shadow-sm hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
              Ya, Hapus User
            </button>
          </form>
          <button type="button" onclick="closeDeleteModal()"
            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-300 transition bg-gray-800 border border-gray-600 rounded-lg shadow-sm hover:text-white hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            Batal
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function openDeleteModal(actionUrl, userName) {
      // Set URL ke form
      document.getElementById('deleteUserForm').action = actionUrl;
      // Set Nama User untuk konfirmasi
      document.getElementById('userNameToDelete').innerText = userName;
      // Tampilkan Modal
      document.getElementById('deleteUserModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
      document.getElementById('deleteUserModal').classList.add('hidden');
    }
  </script>

</x-app-layout>
