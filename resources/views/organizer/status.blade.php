<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-white">
      {{ __('Status Akun') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

      <div class="bg-[#27272a] border border-gray-800 overflow-hidden shadow-2xl sm:rounded-2xl text-center p-10">

        @if ($user->organizer_status === 'pending')
          <div class="flex flex-col items-center animate-pulse">
            <div
              class="flex items-center justify-center w-24 h-24 mb-6 border-4 rounded-full bg-yellow-900/30 border-yellow-500/20">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-12 h-12 text-yellow-500">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
              </svg>
            </div>
            <h3 class="mb-2 text-3xl font-black text-white">Menunggu Persetujuan</h3>
            <p class="max-w-md mx-auto mb-8 text-gray-400">
              Terima kasih telah mendaftar! Akun Anda sedang ditinjau oleh Admin kami. Mohon tunggu 1x24 jam untuk
              proses verifikasi.
            </p>
            <div class="px-6 py-3 border border-gray-700 rounded-lg bg-black/20">
              <span class="text-sm text-gray-500">Status Saat Ini:</span>
              <span class="ml-2 font-bold tracking-wider text-yellow-400 uppercase">Pending</span>
            </div>
          </div>
        @elseif($user->organizer_status === 'rejected')
          <div class="flex flex-col items-center">
            <div
              class="flex items-center justify-center w-24 h-24 mb-6 border-4 rounded-full bg-red-900/30 border-red-500/20">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-12 h-12 text-red-500">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
              </svg>
            </div>
            <h3 class="mb-2 text-3xl font-black text-white">Pendaftaran Ditolak</h3>
            <p class="max-w-md mx-auto mb-8 text-gray-400">
              Maaf, pendaftaran Anda sebagai Event Organizer tidak dapat kami setujui saat ini karena data tidak
              memenuhi syarat.
            </p>

            <div class="w-full max-w-md p-4 mb-8 border bg-red-900/10 border-red-900/50 rounded-xl">
              <p class="text-sm font-semibold text-red-400">
                Silakan hapus akun ini jika Anda ingin mencoba mendaftar ulang dengan data yang benar.
              </p>
            </div>

            <form id="deleteAccountForm" action="{{ route('organizer.account.delete') }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="button" onclick="openDeleteModal()"
                class="flex items-center gap-2 px-8 py-3 font-bold text-white transition bg-red-600 shadow-lg hover:bg-red-700 rounded-xl shadow-red-600/20">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
                Hapus Akun & Daftar Ulang
              </button>
            </form>
          </div>
        @endif

      </div>
    </div>
  </div>

  <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
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
              <h3 class="text-lg font-bold leading-6 text-white" id="modal-title">Yakin Hapus Akun?</h3>
              <div class="mt-2">
                <p class="text-sm text-gray-400">
                  Tindakan ini bersifat <span class="font-bold text-red-400">PERMANEN</span>.
                  Semua data profil dan event yang pernah Anda buat akan dihapus dari sistem.
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="gap-2 px-4 py-3 bg-black/20 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="button" onclick="confirmDeleteAccount()"
            class="inline-flex justify-center w-full px-4 py-2 text-base font-bold text-white transition bg-red-600 border border-transparent rounded-lg shadow-sm hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
            Ya, Hapus Permanen
          </button>
          <button type="button" onclick="closeDeleteModal()"
            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-300 transition bg-gray-800 border border-gray-600 rounded-lg shadow-sm hover:text-white hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            Batal
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function openDeleteModal() {
      document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
      document.getElementById('deleteModal').classList.add('hidden');
    }

    function confirmDeleteAccount() {
      // Submit form asli yang ada ID-nya
      document.getElementById('deleteAccountForm').submit();
    }
  </script>

</x-app-layout>
