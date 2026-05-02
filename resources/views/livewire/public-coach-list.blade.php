<div class="py-12 px-4 sm:px-6 lg:px-8 min-h-screen">
    <div class="max-w-7xl mx-auto">

        {{-- Header & Breadcrumb --}}
        <div class="mb-8 text-center sm:text-left sm:flex sm:items-center sm:justify-between">
            <x-page-header title="Daftar Pelatih" :breadcrumbs="[['label' => 'Direktori', 'url' => route('public.menu')], ['label' => 'Pelatih', 'url' => null]]" :search="true"
                placeholder="Cari nama pelatih..." />
        </div>

        {{-- Hint Text --}}
        <p class="text-sm text-indigo-500 dark:text-indigo-400 mb-6 sm:-mt-6 animate-pulse text-center sm:text-left">
            (Klik pada kartu pelatih untuk melihat detail profil, unit binaan, dan kontak)
        </p>

        {{-- Coach Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @forelse($coaches as $coach)
                <div wire:key="coach-{{ $coach->id }}"
                    wire:click="$dispatch('show-profile', { id: {{ $coach->id }} })"
                    class="bg-white dark:bg-slate-800/80 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700/60 overflow-hidden hover:shadow-lg hover:border-indigo-400 dark:hover:border-indigo-600 transition-all duration-300 transform hover:-translate-y-1 cursor-pointer relative group flex flex-col h-full">


                    {{-- Card Content: Avatar, Info & Icon --}}
                    <div class="p-5 flex items-center gap-4">
                        {{-- Avatar & Badge --}}
                        <div class="relative shrink-0">
                            <img class="h-14 w-14 rounded-full object-cover ring-2 ring-slate-100 dark:ring-slate-700 group-hover:ring-indigo-200 dark:group-hover:ring-indigo-800 transition-all"
                                src="{{ $coach->profile_photo_url }}" alt="{{ $coach->name }}">
                            {{-- <span class="absolute -bottom-1 -right-1 bg-indigo-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-md border border-white dark:border-slate-800 shadow-sm">
                                COACH
                            </span> --}}
                        </div>

                        {{-- Name & Email --}}
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base font-bold text-slate-900 dark:text-white truncate group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors"
                                title="{{ $coach->name }}">
                                {{ $coach->name }}
                            </h3>
                            <p class="text-[13px] text-slate-500 dark:text-slate-400 truncate mt-0.5"
                                title="{{ $coach->email }}">
                                {{ $coach->email }}
                            </p>
                        </div>

                        {{-- Arrow Icon (Indikator bisa diklik) --}}
                        <div
                            class="shrink-0 text-slate-300 dark:text-slate-600 group-hover:text-indigo-500 dark:group-hover:text-indigo-400 transition-colors sm:transform group-hover:translate-x-1 duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full py-12">
                    <x-empty-state icon="users" title="Tidak ada pelatih ditemukan"
                        description="Coba ubah kata kunci pencarian Anda." />
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $coaches->links() }}
        </div>

    </div>

    {{-- MODAL DETAIL PROFILE (Reusable Component) --}}
    <livewire:profile-modal />
</div>
