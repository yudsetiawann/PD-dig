<x-app-layout title="Direktori Anggota">
  <x-slot name="header">
    <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
      Direktori
    </h1>
  </x-slot>

  <div class="py-12 px-5">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- Opsi 1: Daftar Semua Anggota --}}
        <a href="{{ route('public.athletes.all') }}"
          class="group relative block overflow-hidden rounded-xl border border-slate-200 bg-white p-8 hover:border-blue-500 hover:ring-1 hover:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 transition-all duration-300">

          <span
            class="absolute right-4 top-4 rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
            Global
          </span>

          <div class="mt-4 text-slate-900 dark:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-12 text-blue-600 group-hover:scale-110 transition-transform">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
            </svg>
          </div>

          <h3 class="mt-4 text-xl font-bold text-slate-900 dark:text-white">Daftar Anggota</h3>
          <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            Lihat seluruh anggota aktif yang telah terverifikasi dari semua unit latihan.
          </p>
        </a>

        {{-- Opsi 2: Daftar Pelatih (BARU) --}}
        <a href="{{ route('public.coaches') }}"
          class="group relative block overflow-hidden rounded-xl border border-slate-200 bg-white p-8 hover:border-indigo-500 hover:ring-1 hover:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800 transition-all duration-300">
          <span
            class="absolute right-4 top-4 rounded-full bg-indigo-100 px-3 py-1 text-xs font-medium text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400">
            Struktur
          </span>
          <div class="mt-4 text-slate-900 dark:text-white">
            {{-- Icon Academic Cap / Coach --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-12 text-indigo-600 group-hover:scale-110 transition-transform">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M4.26 10.147a60.436 60.436 0 0 0-.491 6.347A48.627 48.627 0 0 1 12 20.904a48.627 48.627 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.905 59.905 0 0 1 12 3.493a59.902 59.902 0 0 1 10.499 5.516 51.337 51.337 0 0 0-2.658.814m-15.482 0A50.697 50.697 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
            </svg>
          </div>
          <h3 class="mt-4 text-xl font-bold text-slate-900 dark:text-white">Daftar Pelatih</h3>
          <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            Cari data pelatih dan unit latihan yang dibinanya.
          </p>
        </a>

        {{-- Opsi 3: Daftar Ranting --}}
        <a href="{{ route('public.units') }}"
          class="group relative block overflow-hidden rounded-xl border border-slate-200 bg-white p-8 hover:border-emerald-500 hover:ring-1 hover:ring-emerald-500 dark:border-slate-700 dark:bg-slate-800 transition-all duration-300">

          <span
            class="absolute right-4 top-4 rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
            Per Unit
          </span>

          <div class="mt-4 text-slate-900 dark:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-12 text-emerald-600 group-hover:scale-110 transition-transform">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
            </svg>
          </div>

          <h3 class="mt-4 text-xl font-bold text-slate-900 dark:text-white">Daftar Ranting</h3>
          <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            Cari anggota berdasarkan lokasi Unit Latihan atau Ranting mereka.
          </p>
        </a>

      </div>
    </div>
  </div>
</x-app-layout>
