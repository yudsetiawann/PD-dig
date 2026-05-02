<x-app-layout title="Portal Informasi">
    <x-slot name="header">
        Portal Informasi Perisai Diri
    </x-slot>

    <div class="pb-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Kategori Filter --}}
        {{-- Kategori Filter (Mobile-First: Swipeable Horizontal) --}}
        <div class="relative mb-8">
            {{-- Container scroll horizontal dengan efek padding edge-to-edge di mobile --}}
            <div
                class="flex overflow-x-auto gap-2 pb-2 -mx-4 px-4 sm:mx-0 sm:px-0 sm:flex-wrap sm:justify-center [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">

                <a href="{{ route('news.index') }}"
                    class="shrink-0 whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium transition-colors {{ !request('category') ? 'bg-blue-600 text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                    Semua
                </a>

                <a href="{{ route('news.index', ['category' => 'Materi Edukasi']) }}"
                    class="shrink-0 whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium transition-colors {{ request('category') == 'Materi Edukasi' ? 'bg-blue-600 text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                    Materi Edukasi
                </a>

                <a href="{{ route('news.index', ['category' => 'Info Pertandingan']) }}"
                    class="shrink-0 whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium transition-colors {{ request('category') == 'Info Pertandingan' ? 'bg-blue-600 text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                    Info Pertandingan
                </a>

                <a href="{{ route('news.index', ['category' => 'Berita Event']) }}"
                    class="shrink-0 whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium transition-colors {{ request('category') == 'Berita Event' ? 'bg-blue-600 text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                    Berita Event
                </a>

            </div>

            {{-- Indikator gradient opsional agar user tahu bisa di-scroll ke kanan pada mobile --}}
            {{-- <div
                class="absolute right-0 top-0 bottom-2 w-8 bg-linear-to-l from-white dark:from-gray-900 to-transparent pointer-events-none sm:hidden">
            </div> --}}
        </div>

        {{-- Grid Berita --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
                <a href="{{ route('news.show', $post) }}"
                    class="group block bg-white dark:bg-slate-800 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-slate-100 dark:border-slate-700 flex-col h-full">
                    {{-- Gambar --}}
                    <div class="relative h-48 overflow-hidden">
                        @if ($post->hasMedia('cover'))
                            <img src="{{ $post->getFirstMediaUrl('cover') }}" alt="{{ $post->title }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
                                <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.008v.008H14v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zm0-6h.008v.008H12V11zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4">
                            <span
                                class="px-3 py-1 text-xs font-bold text-white bg-blue-600/90 backdrop-blur rounded-full shadow-sm">
                                {{ $post->category }}
                            </span>
                        </div>
                    </div>

                    {{-- Konten --}}
                    <div class="p-6 flex flex-col grow">
                        <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 mb-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            {{ $post->published_at->format('d F Y') }}
                        </div>
                        <h3
                            class="text-xl font-bold text-slate-900 dark:text-white mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">
                            {{ $post->title }}
                        </h3>
                        <div class="text-slate-600 dark:text-slate-400 text-sm line-clamp-3 mb-4">
                            {!! Str::limit(strip_tags($post->content), 100) !!}
                        </div>

                        <div
                            class="mt-auto pt-4 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between">
                            <span class="text-sm font-medium text-blue-600 dark:text-blue-400">Baca Selengkapnya
                                &rarr;</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-12 text-center">
                    <p class="text-slate-500 dark:text-slate-400">Belum ada berita dalam kategori ini.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $posts->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
