<x-app-layout title="Daftar Event">
  <x-slot name="header">
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
      Temukan Event Menarik
    </h1>
  </x-slot>

  <div class="px-5">
    {{-- Grid untuk daftar event --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
      @forelse ($events as $event)
        {{-- Cek apakah event sudah expired --}}
        @php $isExpired = $event->starts_at->isPast(); @endphp

        {{-- Kontainer Kartu --}}
        <div @class([
            'flex flex-col overflow-hidden rounded-lg shadow-lg transition-transform duration-300 hover:scale-105',
            'bg-white dark:bg-gray-800' => !$isExpired,
            'bg-gray-100 dark:bg-gray-700/50 opacity-75' => $isExpired, // Gaya abu-abu
        ])>
          {{-- Gambar Thumbnail --}}
          @if ($event->hasMedia('thumbnails'))
            <img class="h-48 w-full object-cover" src="{{ $event->getFirstMediaUrl('thumbnails') }}"
              alt="{{ $event->title }}">
          @else
            {{-- Placeholder jika tidak ada gambar --}}
            <div class="flex h-48 w-full items-center justify-center bg-gray-200 dark:bg-gray-700">
              <svg class="size-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
              </svg>
            </div>
          @endif

          {{-- Konten Teks --}}
          <div class="flex flex-1 flex-col justify-between p-4">

            {{-- BAGIAN 1: Konten Utama (Judul, Tanggal, Lokasi) --}}
            <div>
              <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                {{ $event->title }}
              </h3>
              <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                <time
                  datetime="{{ $event->starts_at->toIso8601String() }}">{{ $event->starts_at->format('d M Y') }}</time>
              </p>
              <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                {{ $event->location }}
              </p>
            </div>

            {{-- BAGIAN 2: Footer Kartu (Badge, Harga, Tombol) --}}
            <div class="mt-2 flex items-end justify-between">
              {{-- Sisi Kiri Footer (Badge & Harga) --}}
              <div>
                {{-- Badge Status --}}
                <div class="mb-2"> {{-- Ditambah margin bottom agar rapi --}}
                  @if ($isExpired)
                    <span
                      class="rounded-full bg-gray-200 px-3 py-1 text-sm font-semibold text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                      Event Selesai
                    </span>
                  @elseif ($event->ticket_quota > 0)
                    <span
                      class="rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-800 dark:bg-green-900 dark:text-green-200">
                      Tiket Tersedia
                    </span>
                  @else
                    <span
                      class="rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-800 dark:bg-red-900 dark:text-red-200">
                      Tiket Habis
                    </span>
                  @endif
                </div>

                {{-- Harga --}}
                @php
                  if ($event->has_dynamic_pricing && is_array($event->level_prices)) {
                      $prices = array_values($event->level_prices);
                      $min = min($prices);
                      $max = max($prices);
                  }
                @endphp
                <p class="mt-2 font-bold text-gray-900 dark:text-white">
                  @if ($event->has_dynamic_pricing && !empty($event->level_prices))
                    Rp. {{ number_format($min, 0, ',', '.') }} – {{ number_format($max, 0, ',', '.') }}
                  @else
                    Rp. {{ number_format($event->ticket_price, 0, ',', '.') }}
                  @endif
                </p>
              </div>

              {{-- Sisi Kanan Footer (Tombol) --}}
              <div class="shrink-0"> {{-- DITAMBAHKAN: Mencegah tombol dari "penyempitan" --}}
                <a href="{{ route('events.show', $event) }}"
                  class="rounded-md bg-blue-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                  Lihat Detail
                </a>
              </div>
            </div>
          </div>
          {{-- Akhir Konten Teks --}}
        </div>
      @empty
        {{-- Tampilan jika tidak ada event --}}
        <div
          class="col-span-1 rounded-lg border-2 border-dashed border-gray-300 p-12 text-center dark:border-gray-700 sm:col-span-2 lg:col-span-3">
          <p class="text-gray-500 dark:text-gray-400">
            Belum ada event yang tersedia saat ini.
          </p>
        </div>
      @endforelse
    </div>

    {{-- Link Paginasi --}}
    <div class="mt-8">
      {{ $events->links() }}
    </div>
  </div>

</x-app-layout>
