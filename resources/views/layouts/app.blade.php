<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="corporate">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'TicketGo') }}</title>
  <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#18181b] text-white">
  <div class="min-h-screen bg-[#18181b]">
    @include('layouts.navigation')

    @if (isset($header))
      <header class="bg-[#18181b] border-b border-gray-700 shadow">
        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="text-white">
            {{ $header }}
          </div>
        </div>
      </header>
    @endif

    <main>
      {{ $slot }}
    </main>
  </div>
</body>

</html>
