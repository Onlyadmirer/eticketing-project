<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $event->title }} - TicketGo</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>

<body class="bg-[#18181b] text-white antialiased">

  <nav x-data="{ open: false }" class="bg-[#18181b] border-b border-gray-800 text-white sticky top-0 z-50">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center gap-4">
          <a href="{{ route('welcome') }}"
            class="flex items-center gap-2 text-sm font-bold text-gray-400 transition hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
              stroke="currentColor" class="w-5 h-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali
          </a>
          <div class="w-px h-6 mx-2 bg-gray-700"></div>
          <span class="text-xl font-bold tracking-wide text-white">TicketGo</span>
        </div>
        <div class="flex items-center gap-4">
          @auth
            <div class="text-sm text-gray-400">Hi, <span class="font-bold text-lime-400">{{ Auth::user()->name }}</span>
            </div>
          @else
            <a href="{{ route('login') }}" class="text-sm font-bold text-white transition hover:text-lime-400">Log in</a>
          @endauth
        </div>
      </div>
    </div>
  </nav>

  <div class="max-w-6xl px-4 py-12 mx-auto sm:px-6 lg:px-8">

    @if (session('error'))
      <div class="px-4 py-3 mb-6 font-bold text-red-200 border border-red-500 bg-red-900/50 rounded-xl">
        {{ session('error') }}
      </div>
    @endif

    <div class="bg-[#27272a] rounded-3xl overflow-hidden shadow-2xl border border-gray-800">
      <div class="md:flex">
        <div class="relative h-64 bg-gray-800 md:w-1/2 md:h-auto">
          @if ($event->image)
            <img src="{{ asset('storage/' . $event->image) }}" class="object-cover w-full h-full">
            <div
              class="absolute inset-0 bg-gradient-to-t from-[#27272a] md:bg-gradient-to-r md:from-transparent md:to-[#27272a]">
            </div>
          @else
            <div class="flex items-center justify-center h-full font-bold text-gray-600">No Image Available</div>
          @endif
        </div>
        <div class="flex flex-col justify-center p-8 md:w-1/2 md:p-12">
          <div class="flex items-center gap-2 mb-4">
            <span
              class="px-3 py-1 text-xs font-bold tracking-wider uppercase border rounded-full bg-lime-400/10 text-lime-400 border-lime-400/20">
              Event Organizer
            </span>
            <span class="text-sm font-semibold text-gray-400">{{ $event->organizer->name }}</span>
          </div>
          <h1 class="mb-4 text-3xl font-black leading-tight text-white md:text-4xl">{{ $event->title }}</h1>
          <div class="mb-8 space-y-3 text-gray-300">
            <div class="flex items-start gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-lime-400 shrink-0" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <div>
                <p class="font-bold text-white">{{ \Carbon\Carbon::parse($event->start_time)->format('l, d F Y') }}</p>
                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB</p>
              </div>
            </div>
            <div class="flex items-start gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-lime-400 shrink-0" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span class="font-medium">{{ $event->location }}</span>
            </div>
          </div>
          <div class="prose-sm prose text-gray-400 prose-invert">
            <h3 class="mb-2 text-lg font-bold text-white">Deskripsi Acara</h3>
            <p>{{ $event->description }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-12">
      <h2 class="pl-4 mb-6 text-2xl font-bold text-white border-l-4 border-lime-400">Pilih Tiket</h2>
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($event->tickets as $ticket)
          <div
            class="bg-[#27272a] border border-gray-800 rounded-2xl p-6 shadow-lg hover:border-lime-500/50 transition-all duration-300 relative group flex flex-col h-full">
            <div
              class="absolute top-0 right-0 w-20 h-20 -mt-2 -mr-2 transition rounded-full bg-lime-400 opacity-10 blur-xl group-hover:opacity-20">
            </div>

            <div class="relative z-10 flex items-start justify-between mb-4">
              <div>
                <h3 class="text-xl font-bold text-white transition group-hover:text-lime-400">{{ $ticket->name }}</h3>
                <p class="mt-1 font-mono text-xs text-gray-500">Sisa Kuota: {{ $ticket->quota }}</p>
              </div>
              <div class="text-right">
                <p class="text-xs text-gray-400">Harga</p>
                <p class="text-lg font-bold text-lime-400">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
              </div>
            </div>

            <div class="h-px my-4 bg-gray-700 border-t border-gray-600 border-dashed"></div>
            <p class="text-gray-400 text-sm mb-6 min-h-[40px] flex-1">
              {{ $ticket->description ?? 'Tiket masuk reguler untuk acara ini.' }}</p>

            <div class="relative z-10 mt-auto">
              @if ($ticket->quota > 0)
                @auth
                  @if (Auth::user()->role === 'user')
                    <div class="flex items-end gap-3">
                      <div class="w-1/3">
                        <label for="qty_{{ $ticket->id }}" class="pl-1 text-sm text-gray-300">Jumlah :</label>
                        <input type="number" id="qty_{{ $ticket->id }}" value="1" min="1"
                          max="{{ $ticket->quota }}"
                          class="w-full py-3 font-bold text-center text-white border border-gray-600 bg-black/30 rounded-xl focus:border-lime-400 focus:ring-lime-400">
                      </div>

                      <button type="button"
                        onclick="openBookingModal('{{ $ticket->name }}', {{ $ticket->price }}, '{{ $ticket->id }}')"
                        class="w-2/3 py-3 font-bold text-black transition transform shadow-lg h-1/2 bg-lime-400 hover:bg-lime-500 rounded-xl active:scale-95 shadow-lime-400/20">
                        Pesan
                      </button>
                    </div>
                  @else
                    <button disabled
                      class="w-full py-3 font-bold text-gray-400 bg-gray-700 cursor-not-allowed rounded-xl">Role Tidak
                      Sesuai</button>
                  @endif
                @else
                  <a href="{{ route('login') }}"
                    class="block w-full py-3 font-bold text-center transition border border-lime-400 text-lime-400 hover:bg-lime-400 hover:text-black rounded-xl">Login
                    untuk Pesan</a>
                @endauth
              @else
                <button disabled
                  class="w-full py-3 font-bold text-red-500 border border-red-900 cursor-not-allowed bg-red-900/30 rounded-xl">TIKET
                  HABIS</button>
              @endif
            </div>
          </div>
        @empty
          <div class="col-span-3 text-center py-10 bg-[#27272a] rounded-2xl border border-dashed border-gray-700">
            <p class="text-gray-500">Belum ada tiket yang tersedia.</p>
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <div id="bookingModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 transition-opacity bg-black/80 backdrop-blur-sm" aria-hidden="true"
        onclick="closeBookingModal()"></div>
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div
        class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-[#27272a] border border-gray-700 rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative">
        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div
              class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto rounded-full bg-lime-900/30 sm:mx-0 sm:h-10 sm:w-10">
              <svg class="w-6 h-6 text-lime-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
              </svg>
            </div>
            <div class="w-full mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3 class="text-lg font-bold leading-6 text-white" id="modal-title">Konfirmasi Pemesanan</h3>
              <div class="p-4 mt-4 space-y-2 border border-gray-700 bg-black/20 rounded-xl">

                <div class="flex justify-between text-sm text-gray-400">
                  <span>Jenis Tiket:</span>
                  <span class="font-bold text-white" id="modalTicketName">-</span>
                </div>
                <div class="flex justify-between text-sm text-gray-400">
                  <span>Harga Satuan:</span>
                  <span class="text-white" id="modalUnitPrice">-</span>
                </div>
                <div class="flex justify-between text-sm text-gray-400">
                  <span>Jumlah:</span>
                  <span class="font-bold text-lime-400" id="modalQtyDisplay">0</span>
                </div>

                <div class="h-px my-2 bg-gray-700"></div>

                <div class="flex items-center justify-between">
                  <span class="text-sm text-gray-300">Total Bayar:</span>
                  <span class="text-xl font-black text-lime-400" id="modalTotalPrice">Rp 0</span>
                </div>
              </div>
              <p class="mt-3 text-xs text-gray-500">
                Pastikan pesanan Anda benar. Tiket tidak dapat dikembalikan.
              </p>
            </div>
          </div>
        </div>
        <div class="gap-2 px-4 py-3 bg-black/20 sm:px-6 sm:flex sm:flex-row-reverse">
          <form id="bookingForm" action="{{ route('user.bookings.store') }}" method="POST">
            @csrf
            <input type="hidden" name="ticket_id" id="modalTicketId">
            <input type="hidden" name="quantity" id="modalQtyInput"> <button type="submit"
              class="inline-flex justify-center w-full px-4 py-2 text-base font-bold text-black transition border border-transparent rounded-lg shadow-sm bg-lime-400 hover:bg-lime-500 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
              Bayar Sekarang
            </button>
          </form>
          <button type="button" onclick="closeBookingModal()"
            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-300 transition bg-gray-800 border border-gray-600 rounded-lg shadow-sm hover:text-white hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            Batal
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function openBookingModal(name, price, id) {
      let qtyInput = document.getElementById('qty_' + id);
      let qty = parseInt(qtyInput.value);

      if (qty < 1 || isNaN(qty)) {
        alert("Jumlah tiket minimal 1");
        return;
      }

      let total = price * qty;

      // 3. Format Rupiah (Intl.NumberFormat)
      let formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
      });

      document.getElementById('modalTicketName').innerText = name;
      document.getElementById('modalUnitPrice').innerText = formatter.format(price);
      document.getElementById('modalQtyDisplay').innerText = qty + "x";
      document.getElementById('modalTotalPrice').innerText = formatter.format(total);

      document.getElementById('modalTicketId').value = id;
      document.getElementById('modalQtyInput').value = qty;

      document.getElementById('bookingModal').classList.remove('hidden');
    }

    function closeBookingModal() {
      document.getElementById('bookingModal').classList.add('hidden');
    }
  </script>

</body>

</html>
