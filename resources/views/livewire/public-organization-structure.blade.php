<div class="py-12 min-h-screen">
    <div class="pt-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="text-center mb-8"> {{-- Margin bottom dikurangi sedikit --}}
            <h2 class="-mt-2 text-3xl tracking-tight font-bold text-gray-900 dark:text-white">
                Struktur Organisasi
            </h2>
            <p class="mt-4 text-xl text-gray-500 dark:text-gray-400">
                Pengurus Unit Perisai Diri Kabupaten Tasikmalaya
            </p>
            <p class="text-sm text-blue-500 mt-2 animate-pulse">
                (Klik pada kartu untuk melihat detail profil & lokasi melatih)
            </p>
        </div>

        {{-- Search Bar --}}
        <x-page-header :search="true" placeholder="Cari nama pengurus..." />


        {{-- Grid Card --}}
        @if ($members->isEmpty())
            {{-- TAMPILAN JIKA TIDAK ADA HASIL --}}
            <div class="text-center py-12">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Tidak ada anggota ditemukan</h3>
                <p class="mt-1 text-gray-500 dark:text-gray-400">Coba kata kunci pencarian yang lain.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($members as $member)
                    <div wire:key="member-{{ $member->id }}" wire:click="$dispatch('show-profile', { id: {{ $member->id }} })"
                        class="group bg-white dark:bg-slate-900 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-800 hover:shadow-2xl hover:border-blue-400 dark:hover:border-blue-600 transition-all duration-300 transform hover:-translate-y-2 cursor-pointer relative">


<div class="p-6 text-center">
                            <x-avatar :model="$member" class="h-24 w-24 mx-auto mb-2" />

                            <h3 class="text-lg font-bold text-blue-600 dark:text-blue-400 mb-1">
                                {{ $member->organizationPosition?->name ?? '-' }}
                            </h3>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                {{ $member->name }}
                            </h4>
                            <span class="inline-flex items-center text-xs font-medium text-gray-400">
                                Lihat Detail &rarr;
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- MODAL DETAIL PROFILE --}}
    <livewire:profile-modal />
</div>
