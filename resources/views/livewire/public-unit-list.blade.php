<div class="py-12 px-5">
    <div class="pt-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Header & Search --}}
        <x-page-header
            title="Daftar Ranting / Unit"
            :breadcrumbs="[
                ['label' => 'Direktori', 'url' => route('public.menu')],
                ['label' => 'Ranting', 'url' => null],
            ]"
            :search="true"
            placeholder="Cari nama ranting..."
        />


        {{-- Grid Unit --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($units as $unit)
                <a href="{{ route('public.athletes.by-unit', $unit) }}"
                    class="group block rounded-xl border border-slate-200 bg-white p-6 shadow-sm hover:border-blue-500 hover:ring-1 hover:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 transition-all flex-col h-full">
                    {{-- Added flex flex-col h-full agar footer kartu rata bawah --}}

                    <div class="flex items-center justify-between">
                        <h3
                            class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-blue-600 line-clamp-1">
                            {{ $unit->name }}
                        </h3>
                        <x-status-badge variant="default">{{ $unit->athletes_count }} Anggota</x-status-badge>
                    </div>

                    <div class="mt-4 flex items-start gap-2 text-sm text-slate-600 dark:text-slate-400">
                        <svg class="mt-0.5 size-4 shrink-0 text-slate-400" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        <span class="line-clamp-2">{{ $unit->address ?? 'Alamat tidak tersedia' }}</span>
                    </div>

                    {{-- BAGIAN BARU: NAMA PELATIH --}}
                    <div class="mt-3 flex items-start gap-2 text-sm text-slate-600 dark:text-slate-400">
                        <svg class="mt-0.5 size-4 shrink-0 text-slate-400" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A1.875 1.875 0 0 1 18 22.5H6A1.875 1.875 0 0 1 4.501 20.118Z" />
                        </svg>
                        <span class="line-clamp-2">
                            <span class="font-semibold text-slate-700 dark:text-slate-300">Dilatih oleh:</span>
                            @if ($unit->coaches->isNotEmpty())
                                {{ $unit->coaches->pluck('name')->join(', ') }}
                            @else
                                <span class="italic text-slate-400">Belum ada pelatih</span>
                            @endif
                        </span>
                    </div>

                    {{-- Spacer agar tombol selalu di bawah --}}
                    <div class="grow"></div>

                    <div
                        class="mt-4 flex items-center justify-end border-t border-slate-100 dark:border-slate-700 pt-4">
                        <span class="text-sm font-medium text-blue-600 group-hover:underline dark:text-blue-400">
                            Lihat Anggota &rarr;
                        </span>
                    </div>
                </a>
            @empty
                <div class="col-span-full">
                    <x-empty-state
                        icon="search"
                        title="Tidak ada ranting ditemukan"
                        description="Coba ubah kata kunci pencarian Anda."
                    />
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $units->links() }}
        </div>
    </div>
</div>
