<div class="py-12 px-4 sm:px-6 lg:px-8 min-h-screen">
    <div class="max-w-7xl mx-auto">

        {{-- Header & Breadcrumb Dinamis --}}
        <div class="mb-8 text-center sm:text-left sm:flex sm:items-center sm:justify-between">
            <x-page-header :title="$pageTitle" :breadcrumbs="$unit && $unit->exists
                ? [
                    ['label' => 'Direktori', 'url' => route('public.menu')],
                    ['label' => 'Ranting', 'url' => route('public.units')],
                    ['label' => $unit->name, 'url' => null],
                ]
                : [
                    ['label' => 'Direktori', 'url' => route('public.menu')],
                    ['label' => 'Semua Anggota', 'url' => null],
                ]" :search="true" placeholder="Cari nama / NIA..." />
        </div>

        {{-- Hint Text --}}
        <p class="text-sm text-blue-500 dark:text-blue-400 mb-6 sm:-mt-6 animate-pulse text-center sm:text-left">
            (Klik pada kartu anggota untuk melihat detail tingkatan sabuk dan unit)
        </p>

        {{-- Grid / List Atlet --}}
        @if ($athletes->isEmpty())
            <div class="mt-8">
                <x-empty-state icon="users" title="Tidak ada anggota ditemukan"
                    description="Coba ubah kata kunci pencarian atau filter Anda." />
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 mt-6">
                @foreach ($athletes as $athlete)
                    <div wire:key="athlete-{{ $athlete->id }}"
                        wire:click="$dispatch('show-profile', { id: {{ $athlete->id }} })"
                        class="bg-white dark:bg-slate-800/80 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700/60 overflow-hidden hover:shadow-lg hover:border-blue-400 dark:hover:border-blue-600 transition-all duration-300 transform hover:-translate-y-1 cursor-pointer relative group flex flex-col h-full">

                        {{-- Card Content: Avatar, Info & Icon --}}
                        <div class="p-4 flex items-center gap-4 h-full">
                            {{-- Avatar --}}
                            <div class="relative shrink-0">
                                <x-avatar :model="$athlete"
                                    class="h-14 w-14 ring-2 ring-slate-100 dark:ring-slate-700 group-hover:ring-blue-200 dark:group-hover:ring-blue-800 transition-all" />
                            </div>

                            {{-- Name & NIA --}}
                            <div class="flex-1 min-w-0">
                                <h3 class="text-[15px] font-bold text-slate-900 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors"
                                    title="{{ $athlete->name }}">
                                    {{ $athlete->name }}
                                </h3>
                                <p class="text-[13px] text-slate-500 dark:text-slate-400 truncate mt-0.5">
                                    NIA: <span class="font-medium">{{ $athlete->nia ?? '-' }}</span>
                                </p>
                            </div>

                            {{-- Arrow Icon (Indikator bisa diklik) --}}
                            <div
                                class="shrink-0 text-slate-300 dark:text-slate-600 group-hover:text-blue-500 dark:group-hover:text-blue-400 transition-colors sm:transform group-hover:translate-x-1 duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $athletes->links() }}
            </div>
        @endif

    </div>

    {{-- MODAL DETAIL PROFILE --}}
    <livewire:profile-modal />
</div>
