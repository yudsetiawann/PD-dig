<div class="py-12 px-5">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    {{-- Header & Breadcrumb --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Daftar Pelatih</h2>
        <nav class="flex text-sm text-slate-500 dark:text-slate-400 mt-1" aria-label="Breadcrumb">
          <ol class="flex items-center space-x-2">
            <li><a href="{{ route('public.menu') }}" class="hover:text-blue-600">Direktori</a></li>
            <li><span class="text-slate-400">/</span></li>
            <li class="font-medium text-slate-900 dark:text-white">Pelatih</li>
          </ol>
        </nav>
      </div>

      {{-- Search Input (Real-time Livewire) --}}
      <div class="relative w-full md:w-64">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama pelatih..."
          class="w-full rounded-lg border-slate-300 pl-10 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-800 dark:border-slate-700 dark:text-white">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
          <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
            fill="currentColor">
            <path fill-rule="evenodd"
              d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
              clip-rule="evenodd" />
          </svg>
        </div>
      </div>
    </div>

    {{-- Coach Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      @forelse($coaches as $coach)
        <div
          class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-md transition-all duration-300 group flex flex-col h-full">

          {{-- Header Card: Avatar & Nama --}}
          <div class="p-6 flex flex-col items-center text-center border-b border-slate-100 dark:border-slate-700/50">
            {{-- Foto Profil / Avatar --}}
            <div class="relative mb-4">
              <img
                class="h-24 w-24 rounded-full object-cover ring-4 ring-slate-50 dark:ring-slate-700 group-hover:ring-indigo-50 dark:group-hover:ring-indigo-900 transition-all"
                src="{{ $coach->profile_photo_url }}" alt="{{ $coach->name }}">

              {{-- Badge Role --}}
              <span
                class="absolute bottom-0 right-0 bg-indigo-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full border-2 border-white dark:border-slate-800">
                COACH
              </span>
            </div>

            <h3 class="text-lg font-bold text-slate-900 dark:text-white line-clamp-1">
              {{ $coach->name }}
            </h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
              {{ $coach->email }}
            </p>
          </div>

          {{-- Body Card: Unit Binaan --}}
          <div class="p-5 bg-slate-50/50 dark:bg-slate-800/50 grow">
            <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">
              Unit Binaan
            </h4>

            @if ($coach->coachedUnits->isNotEmpty())
              <div class="flex flex-wrap gap-2">
                @foreach ($coach->coachedUnits->take(3) as $unit)
                  <span
                    class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-white dark:bg-slate-700 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-600">
                    {{ $unit->name }}
                  </span>
                @endforeach

                {{-- Jika unit lebih dari 3 --}}
                @if ($coach->coachedUnits->count() > 3)
                  <span
                    class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-slate-100 dark:bg-slate-700 text-slate-500">
                    +{{ $coach->coachedUnits->count() - 3 }} Lainnya
                  </span>
                @endif
              </div>
            @else
              <p class="text-sm text-slate-400 italic">Belum ada unit binaan.</p>
            @endif
          </div>

          {{-- Footer Card: Contact (Optional) --}}
          @if ($coach->phone_number)
            <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-700 bg-white dark:bg-slate-800">
              <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $coach->phone_number)) }}"
                target="_blank"
                class="flex items-center justify-center gap-2 w-full text-sm font-medium text-green-600 hover:text-green-700 dark:text-green-500 dark:hover:text-green-400 transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                  <path
                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                </svg>
                Hubungi via WhatsApp
              </a>
            </div>
          @endif

        </div>
      @empty
        <div class="col-span-full py-12 text-center">
          <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-white">Tidak ada pelatih ditemukan</h3>
          <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Coba ubah kata kunci pencarian Anda.</p>
        </div>
      @endforelse
    </div>

    <div class="mt-8">
      {{ $coaches->links() }}
    </div>
  </div>
</div>
