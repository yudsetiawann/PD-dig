<x-app-layout :title="$post->title">
  <div class="py-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Tombol Kembali --}}
    <a href="{{ route('news.index') }}"
      class="inline-flex items-center text-sm text-slate-500 hover:text-blue-600 mb-6 transition-colors">
      &larr; Kembali ke Daftar Berita
    </a>

    <article class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm overflow-hidden">
      {{-- Header Gambar --}}
      @if ($post->hasMedia('cover'))
        <div class="w-full h-64 md:h-96 overflow-hidden">
          <img src="{{ $post->getFirstMediaUrl('cover') }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
        </div>
      @endif

      <div class="p-8 md:p-12">
        {{-- Meta --}}
        <div class="flex flex-wrap items-center gap-4 mb-6">
          <span
            class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wider dark:bg-blue-900/30 dark:text-blue-300">
            {{ $post->category }}
          </span>
          <span class="text-sm text-slate-500 dark:text-slate-400 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            {{ $post->published_at->format('d F Y') }}
          </span>
        </div>

        {{-- Judul --}}
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mb-8 leading-tight">
          {{ $post->title }}
        </h1>

        {{-- Konten (Prose Typography) --}}
        <div class="prose prose-lg prose-slate dark:prose-invert max-w-none text-slate-900 dark:text-white">
          {!! $post->content !!}
        </div>
      </div>
    </article>
  </div>
</x-app-layout>
