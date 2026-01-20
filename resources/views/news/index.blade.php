<x-app-layout title="Portal Informasi">
  <x-slot name="header">
      <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Portal Informasi Perisai Diri</h1>
  </x-slot>

  <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      {{-- Kategori Filter --}}
      <div class="flex flex-wrap gap-2 mb-8 justify-center">
          <a href="{{ route('news.index') }}" class="px-4 py-2 rounded-full text-sm font-medium {{ !request('category') ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}">
              Semua
          </a>
          <a href="{{ route('news.index', ['category' => 'Materi Edukasi']) }}" class="px-4 py-2 rounded-full text-sm font-medium {{ request('category') == 'Materi Edukasi' ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}">
              Materi Edukasi
          </a>
          <a href="{{ route('news.index', ['category' => 'Info Pertandingan']) }}" class="px-4 py-2 rounded-full text-sm font-medium {{ request('category') == 'Info Pertandingan' ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}">
              Info Pertandingan
          </a>
          <a href="{{ route('news.index', ['category' => 'Berita Event']) }}" class="px-4 py-2 rounded-full text-sm font-medium {{ request('category') == 'Berita Event' ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}">
              Berita Event
          </a>
      </div>

      {{-- Grid Berita --}}
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          @forelse($posts as $post)
              <a href="{{ route('news.show', $post) }}" class="group block bg-white dark:bg-slate-800 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-slate-100 dark:border-slate-700 flex-col h-full">
                  {{-- Gambar --}}
                  <div class="relative h-48 overflow-hidden">
                      @if($post->hasMedia('cover'))
                          <img src="{{ $post->getFirstMediaUrl('cover') }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                      @else
                          <div class="w-full h-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
                              <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.008v.008H14v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zm0-6h.008v.008H12V11zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"></path></svg>
                          </div>
                      @endif
                      <div class="absolute top-4 left-4">
                          <span class="px-3 py-1 text-xs font-bold text-white bg-blue-600/90 backdrop-blur rounded-full shadow-sm">
                              {{ $post->category }}
                          </span>
                      </div>
                  </div>

                  {{-- Konten --}}
                  <div class="p-6 flex flex-col grow">
                      <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 mb-3">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                          {{ $post->published_at->format('d F Y') }}
                      </div>
                      <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">
                          {{ $post->title }}
                      </h3>
                      <div class="text-slate-600 dark:text-slate-400 text-sm line-clamp-3 mb-4">
                          {!! Str::limit(strip_tags($post->content), 100) !!}
                      </div>

                      <div class="mt-auto pt-4 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between">
                          <span class="text-sm font-medium text-blue-600 dark:text-blue-400">Baca Selengkapnya &rarr;</span>
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
