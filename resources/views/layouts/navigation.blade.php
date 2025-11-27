<nav x-data="{ open: false }" class="bg-[#18181b] border-b border-gray-700 text-white py-2 sticky top-0 z-50">
  <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-14">

      <div class="flex items-center">
        <div class="flex items-center gap-3 shrink-0">
          <a href="{{ route('welcome') }}" class="flex items-center gap-2 group">
            <div class="transition-transform text-lime-400 group-hover:rotate-12">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                <path fill-rule="evenodd"
                  d="M1.5 6.375c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v3.026a.75.75 0 0 1-.375.65 2.249 2.249 0 0 0 0 3.898.75.75 0 0 1 .375.65v3.026c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 17.625v-3.026a.75.75 0 0 1 .374-.65 2.249 2.249 0 0 0 0-3.898.75.75 0 0 1-.374-.65V6.375Zm15-1.125a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-1.5 0V6a.75.75 0 0 1 .75-.75Zm.75 4.5a.75.75 0 0 0-1.5 0v.75a.75.75 0 0 0 1.5 0v-.75Zm-.75 3a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-1.5 0v-.75a.75.75 0 0 1 .75-.75Z"
                  clip-rule="evenodd" />
              </svg>
            </div>
            <span class="text-xl font-bold tracking-wide text-white">TicketGo</span>
          </a>
        </div>
      </div>

      <div class="hidden space-x-8 sm:flex sm:items-center sm:ms-auto">

        <a href="{{ route('welcome') }}"
          class="text-sm font-bold transition duration-150 ease-in-out {{ request()->routeIs('welcome') ? 'text-lime-400' : 'text-gray-300 hover:text-white' }}">
          Home
        </a>

        @auth
          <a href="{{ route('dashboard') }}"
            class="text-sm font-bold transition duration-150 ease-in-out {{ request()->routeIs('dashboard') || request()->routeIs('user.bookings.*') || request()->routeIs('organizer.dashboard') || request()->routeIs('admin.dashboard') ? 'text-lime-400' : 'text-gray-300 hover:text-white' }}">
            Dashboard
          </a>

          @if (Auth::user()->role === 'admin')
            <a href="{{ route('admin.users.index') }}"
              class="text-sm font-bold transition duration-150 ease-in-out {{ request()->routeIs('admin.users.*') ? 'text-lime-400' : 'text-gray-300 hover:text-white' }}">
              Manage Users
            </a>

            <a href="{{ route('admin.events.index') }}"
              class="text-sm font-bold transition duration-150 ease-in-out {{ request()->routeIs('admin.events.*') ? 'text-lime-400' : 'text-gray-300 hover:text-white' }}">
              Manage Events
            </a>
          @endif

          @if (Auth::user()->role === 'organizer')
            <a href="{{ route('organizer.events.index') }}"
              class="text-sm font-bold transition duration-150 ease-in-out {{ request()->routeIs('organizer.events.*') ? 'text-lime-400' : 'text-gray-300 hover:text-white' }}">
              My Events
            </a>
          @endif

          <div class="relative ms-4">
            <x-dropdown align="right" width="48">
              <x-slot name="trigger">
                <button
                  class="inline-flex items-center px-3 py-2 text-sm font-bold leading-4 text-gray-300 transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:text-white hover:bg-gray-700 focus:outline-none">
                  <div>{{ Auth::user()->name }}</div>
                  <div class="ms-1">
                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                    </svg>
                  </div>
                </button>
              </x-slot>

              <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                  {{ __('Profile') }}
                </x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Log Out') }}
                  </x-dropdown-link>
                </form>
              </x-slot>
            </x-dropdown>
          </div>
        @else
          <a href="{{ route('login') }}" class="text-sm font-bold text-gray-300 transition hover:text-white">Log in</a>
          @if (Route::has('register'))
            <a href="{{ route('register') }}"
              class="px-4 py-2 text-sm font-bold text-gray-900 transition rounded bg-lime-400 hover:bg-lime-300">
              Premium Register
            </a>
          @endif
        @endauth
      </div>

      <div class="flex items-center -me-2 sm:hidden">
        <button @click="open = ! open"
          class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white">
          <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
              stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-[#18181b] border-t border-gray-800">
    <div class="pt-2 pb-3 space-y-1">
      <a href="{{ route('welcome') }}"
        class="block w-full ps-3 pe-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out {{ request()->routeIs('welcome') ? 'border-lime-400 text-lime-400 bg-gray-800' : 'border-transparent text-gray-300 hover:text-white hover:bg-gray-800' }}">
        Home
      </a>

      @auth
        <a href="{{ route('dashboard') }}"
          class="block w-full ps-3 pe-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out {{ request()->routeIs('dashboard') || request()->routeIs('user.bookings.*') || request()->routeIs('organizer.dashboard') ? 'border-lime-400 text-lime-400 bg-gray-800' : 'border-transparent text-gray-300 hover:text-white hover:bg-gray-800' }}">
          Dashboard
        </a>

        @if (Auth::user()->role === 'admin')
          <a href="{{ route('admin.users.index') }}"
            class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-gray-300 hover:text-white hover:bg-gray-800 {{ request()->routeIs('admin.users.*') ? 'border-lime-400 text-lime-400' : '' }}">Manage
            Users</a>
          <a href="{{ route('admin.events.index') }}"
            class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-gray-300 hover:text-white hover:bg-gray-800 {{ request()->routeIs('admin.events.*') ? 'border-lime-400 text-lime-400' : '' }}">Manage
            Events</a>
        @endif

        @if (Auth::user()->role === 'organizer')
          <a href="{{ route('organizer.events.index') }}"
            class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-gray-300 hover:text-white hover:bg-gray-800 {{ request()->routeIs('organizer.events.*') ? 'border-lime-400 text-lime-400' : '' }}">My
            Events</a>
        @endif
      @else
        <a href="{{ route('login') }}"
          class="block w-full py-2 text-gray-300 border-l-4 border-transparent ps-3 pe-4 hover:text-white hover:bg-gray-800">Log
          in</a>
        <a href="{{ route('register') }}"
          class="block w-full py-2 text-gray-300 border-l-4 border-transparent ps-3 pe-4 hover:text-white hover:bg-gray-800">Register</a>
      @endauth
    </div>

    @auth
      <div class="pt-4 pb-1 border-t border-gray-800">
        <div class="px-4">
          <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
          <div class="text-sm font-medium text-gray-400">{{ Auth::user()->email }}</div>
        </div>
        <div class="mt-3 space-y-1">
          <x-responsive-nav-link :href="route('profile.edit')"
            class="text-gray-300 hover:text-white hover:bg-gray-800">{{ __('Profile') }}</x-responsive-nav-link>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
              class="text-gray-300 hover:text-white hover:bg-gray-800">{{ __('Log Out') }}</x-responsive-nav-link>
          </form>
        </div>
      </div>
    @endauth
  </div>
</nav>
