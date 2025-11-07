<x-app-layout :title="$event->title"> {{-- Set judul halaman --}}

  {{-- Tampilkan pesan error jika ada (misal tiket habis) --}}
  @if (session('error'))
    <div class="mb-4 rounded-md bg-red-50 p-4 dark:bg-red-900/30">
      <p class="text-sm font-medium text-red-700 dark:text-red-300">{{ session('error') }}</p>
    </div>
  @endif

  <div class="mt-18 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
    {{-- Gambar Utama --}}
    @if ($event->hasMedia('thumbnails'))
      <img src="{{ $event->getFirstMediaUrl('thumbnails') }}" alt="{{ $event->title }}"
        class="h-64 w-full object-cover sm:h-80 lg:h-96">
    @endif

    <div class="p-6 lg:p-8">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $event->title }}</h1>

      <div class="mt-4 flex flex-wrap items-center gap-x-6 gap-y-2 text-gray-600 dark:text-gray-400">
        <div class="flex items-center gap-1">
          <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
          </svg>
          <span>{{ $event->starts_at->format('d M Y') }}
            {{ $event->ends_at ? ' - ' . $event->ends_at->format('d M Y') : '' }}</span>
        </div>
        <div class="flex items-center gap-1">
          <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
          </svg>
          <span>{{ $event->location }}</span>
        </div>
        <div class="flex items-center gap-1">
          <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-1.5h5.25m-5.25 0h3m-3 0h-3m2.25-7.5A1.125 1.125 0 0113.5 7.125v-1.5a1.125 1.125 0 011.125-1.125h-1.5a1.125 1.125 0 01-1.125 1.125v1.5m1.5-.75V7.5m-5.25 6h.008v.008H9.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 2.25h.008v.008H9.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
          </svg>
          <span>Sisa Kuota: {{ $event->ticket_quota }}</span>
        </div>
      </div>

      {{-- Tombol Beli --}}
      <div class="mt-8">
        {{-- Variabel untuk cek apakah event sudah lewat --}}
        @php $isExpired = $event->starts_at->isPast(); @endphp

        @if ($isExpired)
          {{-- 1. Jika Event sudah lewat --}}
          <span
            class="inline-block rounded-lg bg-gray-400 px-4 py-2 text-md md:text-lg font-semibold text-white cursor-not-allowed dark:bg-gray-600">
            Event Telah Berakhir
          </span>
        @elseif ($event->ticket_quota > 0)
          {{-- 2. Jika Event masih ada DAN kuota masih ada --}}
          <a href="{{ route('orders.create', $event) }}"
            class="inline-block rounded-lg bg-green-600 px-4 py-2 text-md md:text-lg font-semibold text-white shadow-sm hover:scale-105 transition-transform duration-200">
            Beli Tiket
          </a>
        @else
          {{-- 3. Jika Event masih ada TAPI kuota habis --}}
          <span
            class="inline-block rounded-lg bg-red-400 px-4 py-2 text-md md:text-lg font-semibold text-white cursor-not-allowed dark:bg-red-700">
            Tiket Habis
          </span>
        @endif
      </div>

      {{-- Detail Event --}}
      <div class="mt-10 grid grid-cols-1 gap-10 md:grid-cols-3">
        <div class="md:col-span-2 space-y-8">
          {{-- Deskripsi --}}
          @if ($event->description)
            <div>
              <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Deskripsi Event</h2>
              <div class="prose prose-sm mt-4 max-w-none text-gray-700 dark:text-gray-300 dark:prose-invert">
                {{-- Menggunakan nl2br(e()) tidak aman jika deskripsi mengandung HTML. --}}
                {{-- Jika Anda yakin deskripsi aman/plain text, nl2br(e()) OK. --}}
                {{-- Jika deskripsi dari rich text editor, gunakan {!! $event->description !!} (tapi pastikan di-sanitize di backend) --}}
                {!! nl2br(e($event->description)) !!}
              </div>
            </div>
          @endif

          {{-- Peta Lokasi --}}
          @if ($event->location_map_link)
            <div>
              <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Peta Lokasi</h2>
              <div class="mt-4 aspect-video overflow-hidden rounded-lg">
                <iframe src="{{ $event->location_map_link }}" width="100%" height="450" style="border:0;"
                  allowfullscreen="" loading="lazy"></iframe>
              </div>
            </div>
          @endif
        </div>

        {{-- Info Kontak & Galeri --}}
        <div class="space-y-8">
          {{-- Narahubung --}}
          @if ($event->contact_person_name || $event->contact_person_phone)
            <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700">
              <h3 class="text-base font-semibold text-gray-900 dark:text-white">Narahubung</h3>
              @if ($event->contact_person_name)
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                  {{ $event->contact_person_name }}</p>
              @endif
              @if ($event->contact_person_phone)
                <p class="mt-1 text-sm text-blue-600 dark:text-blue-400">
                  {{ $event->contact_person_phone }}</p>
              @endif
            </div>
          @endif

          {{-- Galeri --}}
          @if ($event->hasMedia('gallery'))
            <div>
              <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Galeri</h2>
              <div class="mt-4 grid grid-cols-2 gap-4">
                @foreach ($event->getMedia('gallery') as $media)
                  <img src="{{ $media->getUrl() }}" alt="Galeri Event"
                    class="aspect-square w-full rounded-lg object-cover hover:scale-105 transition-transform duration-300">
                @endforeach
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
