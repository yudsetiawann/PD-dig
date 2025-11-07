<nav x-data="{ mobileOpen: false }"
  class="fixed top-0 left-0 w-full z-50 transition-all duration-300 bg-gray-600/50 dark:bg-gray-800/50">

  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 items-center justify-between">
      {{-- Logo --}}
      <div class="flex items-center">
        <a href="/" class="flex items-center shrink-0">
          <img src="/img/Logo-PD.png" alt="geTix PD" class="h-10 w-12" />
          <span class="text-md font-semibold text-gray-100 dark:text-gray-200">geTix PD</span>
        </a>
        <div class="hidden md:block">
          <div class="ml-8 flex items-baseline space-x-4">
            <a href="{{ route('home') }}"
              class="{{ request()->routeIs('home') ? 'bg-gray-900/50 text-white' : 'text-gray-100 dark:text-gray-300 hover:bg-gray-600/50 dark:hover:bg-white/5 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium">
              Beranda
            </a>
            <a href="{{ route('events.index') }}"
              class="{{ request()->routeIs('events.index') ? 'bg-gray-900/50 text-white' : 'text-gray-100 dark:text-gray-300 hover:bg-gray-600/50 dark:hover:bg-white/5 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium">
              Events
            </a>
            @auth
              <a href="{{ route('my-tickets.index') }}"
                class="{{ request()->routeIs('my-tickets.index') ? 'bg-gray-900/50 text-white' : 'text-gray-100 dark:text-gray-300 hover:bg-gray-600/50 dark:hover:bg-white/5 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium">
                Tiket Saya
              </a>
            @endauth
          </div>
        </div>
      </div>

      {{-- User Menu Desktop --}}
      <div class="hidden md:block">
        <div class="ml-4 flex items-center md:ml-6">

          {{-- === TOMBOL DARK MODE === --}}
          <button @click="darkMode = !darkMode" type="button"
            class="relative flex items-center w-full rounded-md p-1 text-gray-100 dark:text-gray-300 hover:bg-white/5 mr-3">
            <span class="sr-only">Toggle dark mode</span>
            {{-- Ikon Bulan (tampil saat light mode) --}}
            <svg x-cloak x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke-width="2" stroke="currentColor" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
            </svg>
            {{-- Ikon Matahari (tampil saat dark mode) --}}
            <svg x-cloak x-show="darkMode" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke-width="2" stroke="currentColor" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
            </svg>
          </button>
          {{-- === AKHIR TOMBOL DARK MODE === --}}

          @auth
            <div class="relative" x-data="{ open: false }">
              <button @click="open = !open" class="relative flex max-w-xs items-center rounded-full focus:outline-none">
                <span class="sr-only">Open user menu</span>
                <span
                  class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-600 ring-1 ring-white/10">
                  <span class="text-sm font-medium leading-none text-white">
                    {{ strtoupper(substr(Auth::user()->display_name, 0, 1)) }}
                  </span>
                </span>
                <div class="ml-3 flex items-center">
                  <div
                    class="text-gray-100 dark:text-gray-300 text-sm font-medium transform transition duration-200 group-hover:scale-105 group-hover:text-white">
                    {{ Auth::user()->display_name }}
                  </div>
                  <svg
                    class="ms-2 size-5 text-gray-100 dark:text-gray-300 transform transition duration-200 group-hover:rotate-180 group-hover:text-white"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd" />
                  </svg>
                </div>
              </button>

              {{-- Dropdown --}}
              <div x-cloak x-show="open" @click.outside="open = false" x-transition
                class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-md bg-white dark:bg-gray-800 py-1 ring-1 ring-white/10 shadow-lg focus:outline-none">
                <a href="{{ route('profile.edit') }}"
                  class="block px-4 py-2 text-sm text-gray-800 dark:text-white hover:bg-gray-500/5 dark:hover:bg-white/5">Profil
                  Saya</a>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit"
                    class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-500/5 dark:hover:bg-white/5">
                    Keluar
                  </button>
                </form>
              </div>
            </div>
          @else
            <a href="{{ route('login') }}"
              class="inline-block bg-blue-600 hover:bg-blue-700 text-gray-100 py-2 px-4 rounded-lg font-bold text-sm shadow-lg hover:scale-105 transition duration-200">Masuk</a>
            <a href="{{ route('register') }}"
              class="ml-4 inline-block bg-yellow-500 hover:bg-yellow-600 text-gray-100 py-2 px-4 rounded-lg font-bold text-sm shadow-lg hover:scale-105 transition duration-200">Daftar</a>
          @endauth
        </div>
      </div>

      {{-- Tombol Menu Mobile --}}
      <div class="-mr-2 flex md:hidden">
        {{-- === TOMBOL DARK MODE MOBILE === --}}
        <button @click="darkMode = !darkMode" type="button"
          class="flex items-center w-full rounded-md px-2 py-2 text-base font-medium text-gray-100 dark:text-gray-300 hover:bg-white/5 transition">
          <span class="sr-only">Toggle dark mode</span>
          <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
          </svg>
          <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
          </svg>
        </button>
        {{-- === AKHIR TOMBOL DARK MODE MOBILE === --}}
        <button @click="mobileOpen = !mobileOpen"
          class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-100 dark:text-gray-400 hover:bg-white/5 hover:text-white focus:outline-none">
          <span class="sr-only">Open main menu</span>
          <svg x-show="!mobileOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
          <svg x-show="mobileOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  {{-- Menu Mobile --}}
  <div x-show="mobileOpen" x-transition
    class="md:hidden border-t border-white/10 bg-gray-450/80 dark:bg-gray-800/80 backdrop-blur-lg">
    <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
      <a href="{{ route('home') }}"
        class="{{ request()->routeIs('home') ? 'bg-gray-900/50 text-white' : 'text-gray-100 hover:bg-white/5 hover:text-white' }} block rounded-md px-3 py-2 text-base font-medium">
        Beranda
      </a>
      <a href="{{ route('events.index') }}"
        class="{{ request()->routeIs('events.index') ? 'bg-gray-900/50 text-white' : 'text-gray-100 hover:bg-white/5 hover:text-white' }} block rounded-md px-3 py-2 text-base font-medium">
        Events
      </a>
      @auth
        <a href="{{ route('my-tickets.index') }}"
          class="{{ request()->routeIs('my-tickets.index') ? 'bg-gray-900/50 text-white' : 'text-gray-100 hover:bg-white/5 hover:text-white' }} block rounded-md px-3 py-2 text-base font-medium">
          Tiket Saya
        </a>
      @endauth
    </div>

    <div class="border-t border-white/10 pt-4 pb-3">
      @auth
        <div class="flex items-center px-5 group">
          {{-- Avatar bulat --}}
          <div class="flex items-center">
            <div class="shrink-0">
              <span
                class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-600 ring-1 ring-white/10">
                <span class="text-base font-medium leading-none text-white">
                  {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
              </span>
            </div>
            <div class="ml-3">
              <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
              <div class="text-sm font-medium text-gray-300 dark:text-gray-400">{{ Auth::user()->email }}</div>
            </div>
          </div>
        </div>

        <div class="mt-3 space-y-1 px-2">
          <a href="{{ route('profile.edit') }}"
            class="block rounded-md px-3 py-2 text-base font-medium text-gray-100 hover:bg-white/5 hover:text-white">
            Profil Saya
          </a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
              class="block w-full text-left rounded-md px-3 py-2 text-base font-medium text-red-400 hover:bg-white/5 hover:text-white">
              Keluar
            </button>
          </form>

        </div>
      @else
        <div class="space-y-1 px-2">
          <a href="{{ route('login') }}"
            class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">Masuk</a>
          <a href="{{ route('register') }}"
            class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">Daftar</a>
        </div>
      @endauth
    </div>
  </div>
</nav>
