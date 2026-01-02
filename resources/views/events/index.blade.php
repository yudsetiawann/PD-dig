<x-app-layout title="Daftar Event">
  <x-slot name="header">
    <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
      Temukan Event Menarik
    </h1>
  </x-slot>

  {{-- Kontainer Utama dengan padding --}}
  <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">

    {{-- Grid untuk daftar event --}}
    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
      @forelse ($events as $event)
        @php $isExpired = $event->starts_at->isPast(); @endphp

        <div @class([
            'flex flex-col overflow-hidden rounded-xl shadow-md transition-all duration-300 group',
            'bg-white dark:bg-slate-800' => !$isExpired,
            'bg-slate-50 dark:bg-slate-800/70' => $isExpired,
        ])>

          {{-- Gambar Thumbnail --}}
          <div class="relative overflow-hidden">
            @if ($event->hasMedia('thumbnails'))
              <img @class([
                  'h-48 w-full object-cover transition-transform duration-300',
                  'group-hover:scale-105' => !$isExpired,
                  'opacity-60 grayscale' => $isExpired,
              ]) src="{{ $event->getFirstMediaUrl('thumbnails') }}"
                alt="{{ $event->title }}">
            @else
              <div @class([
                  'flex h-48 w-full items-center justify-center bg-slate-100 dark:bg-slate-700',
                  'opacity-60 grayscale' => $isExpired,
              ])>
                <svg @class([
                    'size-16',
                    'text-slate-400 dark:text-slate-500' => !$isExpired,
                    'text-slate-500 dark:text-slate-600' => $isExpired,
                ]) fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
              </div>
            @endif
          </div>

          {{-- Konten Teks --}}
          <div class="flex flex-1 flex-col justify-between p-5">
            <div>
              <h3 @class([
                  'text-lg font-bold',
                  'text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors' => !$isExpired,
                  'text-slate-600 dark:text-slate-400' => $isExpired,
              ])>
                <a href="{{ route('events.show', $event) }}">{{ $event->title }}</a>
              </h3>

              <div @class([
                  'mt-2 space-y-1 text-sm',
                  'text-slate-600 dark:text-slate-400' => !$isExpired,
                  'text-slate-500 dark:text-slate-500' => $isExpired,
              ])>
                <p class="flex items-center">
                  <svg class="mr-1.5 size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                  </svg>
                  <time
                    datetime="{{ $event->starts_at->toIso8601String() }}">{{ $event->starts_at->format('d M Y') }}</time>
                </p>
                <p class="flex items-center">
                  <svg class="mr-1.5 size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                  </svg>
                  {{ $event->location }}
                </p>
              </div>
            </div>

            <div class="mt-6 flex items-end justify-between">
              <div>
                <div class="mb-2">
                  @if ($isExpired)
                    <span
                      class="rounded-full bg-slate-100 px-3 py-1 text-sm font-medium text-slate-700 dark:bg-slate-700 dark:text-slate-300">Event
                      Selesai</span>
                  @elseif ($event->ticket_quota > 0)
                    <span
                      class="rounded-full bg-green-50 px-3 py-1 text-sm font-medium text-green-700 dark:bg-green-900/50 dark:text-green-300">Tiket
                      Tersedia</span>
                  @else
                    <span
                      class="rounded-full bg-red-50 px-3 py-1 text-sm font-medium text-red-700 dark:bg-red-900/50 dark:text-red-300">Tiket
                      Habis</span>
                  @endif
                </div>

                @php
                  if ($event->has_dynamic_pricing && is_array($event->level_prices)) {
                      $prices = array_values($event->level_prices);
                      $min = min($prices);
                      $max = max($prices);
                  }
                @endphp
                <p @class([
                    'text-lg font-bold',
                    'text-slate-900 dark:text-white' => !$isExpired,
                    'text-slate-600 dark:text-slate-400' => $isExpired,
                ])>
                  @if ($event->has_dynamic_pricing && !empty($event->level_prices))
                    Rp. {{ number_format($min, 0, ',', '.') }}
                    @if ($min != $max)
                      <span class="text-sm font-normal text-slate-500"> – {{ number_format($max, 0, ',', '.') }}</span>
                    @endif
                  @else
                    Rp. {{ number_format($event->ticket_price, 0, ',', '.') }}
                  @endif
                </p>
              </div>

              <div class="shrink-0">
                <a href="{{ route('events.show', $event) }}" @class([
                    'inline-block rounded-lg px-4 py-2 text-sm font-medium text-white shadow-sm transition-all duration-200',
                    'bg-blue-600 hover:bg-blue-700 hover:shadow-md focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-blue-600' => !$isExpired,
                    'bg-slate-400 dark:bg-slate-600 cursor-not-allowed' => $isExpired,
                ])
                  @if ($isExpired) aria-disabled="true" onclick="return false;" @endif>
                  {{ $isExpired ? 'Selesai' : 'Lihat Detail' }}
                </a>
              </div>
            </div>
          </div>
        </div>
      @empty
        <div
          class="col-span-1 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 p-12 text-center sm:col-span-2 lg:col-span-3">
          <svg class="mx-auto size-16 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
          </svg>
          <h3 class="mt-4 text-xl font-semibold text-slate-900 dark:text-white">Belum Ada Event</h3>
          <p class="mt-2 text-base text-slate-600 dark:text-slate-400">Kami belum memiliki event baru untuk ditampilkan.
            Silakan cek kembali nanti.</p>
        </div>
      @endforelse
    </div>

    <div class="mt-12">
      {{ $events->links() }}
    </div>
  </div>

  {{-- SECTION CARA MEMESAN TIKET (DIPINDAHKAN DARI HOMEPAGE) --}}
  <section class="py-16 bg-slate-50 dark:bg-slate-950 mt-12 rounded-3xl">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="max-w-3xl mx-auto text-center mb-16">
        <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
          Cara Memesan Tiket
        </h2>
        <p class="mt-4 text-lg text-slate-600 dark:text-slate-400">
          Hanya butuh 4 langkah mudah untuk mengamankan tiket Anda.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

        <div
          class="text-center bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-sm ring-1 ring-slate-200 dark:ring-slate-700">
          <div
            class="flex items-center justify-center h-16 w-16 bg-blue-100 dark:bg-blue-900/30 rounded-full mx-auto mb-6">
            <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">1. Pilih Event</h3>
          <p class="text-sm text-slate-600 dark:text-slate-400">Temukan event yang Anda inginkan dari daftar di atas.
          </p>
        </div>

        <div
          class="text-center bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-sm ring-1 ring-slate-200 dark:ring-slate-700">
          <div
            class="flex items-center justify-center h-16 w-16 bg-blue-100 dark:bg-blue-900/30 rounded-full mx-auto mb-6">
            <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">2. Isi Data</h3>
          <p class="text-sm text-slate-600 dark:text-slate-400">Lengkapi formulir pemesanan dengan data diri valid.</p>
        </div>

        <div
          class="text-center bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-sm ring-1 ring-slate-200 dark:ring-slate-700">
          <div
            class="flex items-center justify-center h-16 w-16 bg-blue-100 dark:bg-blue-900/30 rounded-full mx-auto mb-6">
            <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h6m-6 2.25h6M12 9v10.5m3.75-10.5H21a.75.75 0 0 0 .75-.75V7.5a.75.75 0 0 0-.75-.75H15.75m0 3H21m-3.75 0v10.5m0-10.5h-3.75m3.75 0h3.75M12 3v3.75m0 0h-3.75m3.75 0h3.75M12 3V.75" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">3. Bayar</h3>
          <p class="text-sm text-slate-600 dark:text-slate-400">Selesaikan pembayaran aman via Payment Gateway.</p>
        </div>

        <div
          class="text-center bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-sm ring-1 ring-slate-200 dark:ring-slate-700">
          <div
            class="flex items-center justify-center h-16 w-16 bg-blue-100 dark:bg-blue-900/30 rounded-full mx-auto mb-6">
            <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-1.5h5.25m-5.25 0h5.25m-5.25 0h5.25m-5.25 0h5.25M3 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25H3a2.25 2.25 0 0 1-2.25-2.25V6.75A2.25 2.25 0 0 1 3 4.5Z" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">4. Selesai</h3>
          <p class="text-sm text-slate-600 dark:text-slate-400">Tiket elektronik instan tersedia di akun Anda.</p>
        </div>

      </div>
    </div>
  </section>

</x-app-layout>
