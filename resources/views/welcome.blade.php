<x-app-layout title="Selamat Datang">
  <x-slot name="header">
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
      Selamat Datang
    </h1>
  </x-slot>

  {{-- ========================================== --}}
  {{-- START: NOTIFIKASI LOGIC (TETAP DIPERTAHANKAN) --}}
  {{-- ========================================== --}}
  @auth
    @php
      $user = Auth::user();
      $isCoach = $user->role === 'coach' || $user->hasRole('coach');
      $isAthlete = in_array($user->role, ['athlete', 'user']) || $user->hasRole('athlete');
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6 relative z-20">
      @if ($isCoach)
        @php $hasCoachedUnits = $user->coachedUnits->isNotEmpty(); @endphp
        @if (!$hasCoachedUnits)
          <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg shadow-md animate-fade-in-down">
            <div class="flex">
              <div class="shrink-0">
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Profil Pelatih Belum Lengkap</h3>
                <div class="mt-2 text-sm text-yellow-700">
                  <p>Halo Pelatih <strong>{{ $user->name }}</strong>. Anda belum menentukan <strong>Unit
                      Latihan</strong>. Silakan lengkapi profil.</p>
                </div>
                <div class="mt-4">
                  <a href="{{ route('profile.edit') }}"
                    class="text-sm font-medium text-yellow-800 hover:text-yellow-900 hover:underline">Lengkapi Profil
                    Sekarang →</a>
                </div>
              </div>
            </div>
          </div>
        @endif
      @elseif ($isAthlete)
        @if (is_null($user->unit_id))
          <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg shadow-md animate-fade-in-down">
            <div class="flex">
              <div class="shrink-0">
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Lengkapi Profil Anda</h3>
                <div class="mt-2 text-sm text-yellow-700">
                  <p>Silakan pilih <strong>Unit Latihan</strong> di menu edit profil.</p>
                </div>
                <div class="mt-4"><a href="{{ route('profile.edit') }}"
                    class="text-sm font-medium text-yellow-800 hover:text-yellow-900 hover:underline">Lengkapi Profil
                    →</a></div>
              </div>
            </div>
          </div>
        @elseif ($user->verification_status === 'rejected')
          <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-md animate-pulse">
            <div class="flex">
              <div class="shrink-0"><svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                    clip-rule="evenodd" />
                </svg></div>
              <div class="ml-3 w-full">
                <h3 class="text-sm font-medium text-red-800">Verifikasi Ditolak</h3>
                <div class="mt-2 text-sm text-red-700">
                  <p>Pengajuan verifikasi ditolak. Alasan: "{{ $user->rejection_note }}"</p>
                </div>
                <div class="mt-4"><a href="{{ route('profile.edit') }}"
                    class="text-sm font-medium text-red-800 hover:text-red-900 hover:underline">Perbaiki Data →</a></div>
              </div>
            </div>
          </div>
        @elseif ($user->verification_status === 'pending')
          <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg shadow-md">
            <div class="flex">
              <div class="shrink-0"><svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd" />
                </svg></div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Menunggu Verifikasi</h3>
                <div class="mt-2 text-sm text-blue-700">
                  <p>Data Anda sedang ditinjau oleh pelatih unit <strong>{{ $user->unit->name ?? '' }}</strong>.</p>
                </div>
              </div>
            </div>
          </div>
        @endif
      @endif
    </div>
  @endauth
  {{-- END NOTIFIKASI --}}

  {{-- HERO SECTION --}}
  <section class="relative min-h-[70vh] md:min-h-[80vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
      <img src="{{ asset('img/hero-BG.jpeg') }}" alt="Atlit Pencak Silat" loading="lazy"
        class="w-full h-full object-cover object-center" />
      <div class="absolute inset-0 bg-linear-to-t from-slate-950/60 via-slate-950/50 to-black/20"></div>
    </div>

    <div class="relative z-10 container mx-auto mt-38 md:mt-28 px-4 sm:px-6 lg:px-8 py-32 md:py-48 text-center">
      <h1
        class="text-4xl md:text-6xl font-extrabold text-white tracking-tight shadow-black/50 [text-shadow:0_2px_8px_var(--tw-shadow-color)]">
        Perisai Diri Kabupaten Tasikmalaya
      </h1>
      <p
        class="mt-6 text-lg md:text-xl text-slate-200 max-w-3xl mx-auto shadow-black/50 [text-shadow:0_1px_4px_var(--tw-shadow-color)]">
        Wadah resmi pembinaan prestasi, karakter, dan kekeluargaan Keluarga Silat Nasional Indonesia Perisai Diri Cabang
        Kabupaten Tasikmalaya.
      </p>

      {{-- MODIFIKASI TOMBOL --}}
      <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
        {{-- Tombol 1: Lihat Semua Ranting --}}
        <a href="{{ route('public.units') }}"
          class="w-full sm:w-auto inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg text-lg shadow-lg hover:shadow-blue-500/40 transform hover:scale-105 transition-all duration-300">
          Lihat Semua Ranting
        </a>

        {{-- Tombol 2: Daftar Pelatih --}}
        <a href="{{ route('public.structure') }}"
          class="w-full sm:w-auto inline-block bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white text-white font-bold py-3 px-8 rounded-lg text-lg shadow-lg hover:shadow-white/20 transform hover:scale-105 transition-all duration-300">
          Daftar Pelatih
        </a>
      </div>
    </div>
  </section>

  {{-- SECTION SEJARAH (BARU) --}}
  <section class="py-16 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row items-center gap-12">
        <div class="w-full md:w-1/2">
          <div class="relative rounded-2xl overflow-hidden shadow-2xl">
            <img src="{{ asset('img/Pakdirdjoatmodjo.jpg') }}" alt="Sejarah Perisai Diri" class="w-full h-auto object-cover"
              onerror="this.src='https://placehold.co/600x400?text=Foto+Sejarah'">
            <div class="absolute inset-0 bg-blue-900/10"></div>
          </div>
        </div>
        <div class="w-full md:w-1/2">
          <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white mb-6">
            Sejarah Perisai Diri
          </h2>
          <div class="prose dark:prose-invert text-slate-600 dark:text-slate-300">
            <p class="mb-4">
              Keluarga Silat Nasional Indonesia Perisai Diri didirikan oleh <strong>R.M. Soebandiman
                Dirdjoatmodjo</strong> pada tanggal 2 Juli 1955 di Surabaya. Beliau adalah putra bangsawan Paku Alam
              yang mendedikasikan hidupnya untuk menggali dan melestarikan ilmu beladiri asli Indonesia.
            </p>
            <p class="mb-4">
              Teknik silat Perisai Diri mengandung unsur 156 aliran silat dari berbagai daerah di Indonesia ditambah
              dengan aliran Shaolin dari negeri Tiongkok. Teknik ini diramu menjadi teknik yang efektif, cepat, dan
              tepat dengan motto <em>"Pandai Silat Tanpa Cedera"</em>.
            </p>
            <p>
              Di Kabupaten Tasikmalaya, Perisai Diri terus berkembang mencetak atlet berprestasi dan membentuk karakter
              pemuda yang berbudi pekerti luhur serta memiliki kepercayaan diri yang kuat.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- SECTION EVENT TERAKHIR (PENDUKUNG) --}}
  @if (isset($latestEvents) && $latestEvents->count() > 0)
    <section class="py-16 bg-slate-50 dark:bg-slate-950">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10">
          <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Event Terbaru</h2>
          <a href="{{ route('events.index') }}"
            class="text-blue-600 hover:text-blue-700 dark:text-blue-400 font-medium text-sm flex items-center gap-1">
            Lihat Semua <span aria-hidden="true">&rarr;</span>
          </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @foreach ($latestEvents as $event)
            <a href="{{ route('events.show', $event) }}"
              class="group block bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-md transition-all overflow-hidden border border-slate-200 dark:border-slate-700">
              <div class="h-40 w-full overflow-hidden relative">
                @if ($event->hasMedia('thumbnails'))
                  <img src="{{ $event->getFirstMediaUrl('thumbnails') }}"
                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                    alt="{{ $event->title }}">
                @else
                  <div class="w-full h-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
                    <svg class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.008v.008H14v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zm0-6h.008v.008H12V11zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                    </svg>
                  </div>
                @endif
                <div
                  class="absolute top-2 right-2 bg-white/90 dark:bg-slate-900/90 backdrop-blur px-2 py-1 rounded text-xs font-bold text-slate-800 dark:text-white shadow-sm">
                  {{ $event->starts_at->format('d M') }}
                </div>
              </div>
              <div class="p-4">
                <h3
                  class="text-base font-bold text-slate-900 dark:text-white mb-1 line-clamp-1 group-hover:text-blue-600 transition-colors">
                  {{ $event->title }}
                </h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 flex items-center gap-1">
                  <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  {{ Str::limit($event->location, 30) }}
                </p>
              </div>
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- SECTION LOKASI CABANG (GOOGLE MAPS) --}}
  <section class="py-16 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-10">
        <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
          Lokasi Sekretariat
        </h2>
        <p class="mt-2 text-slate-600 dark:text-slate-400">Kunjungi sekretariat cabang kami untuk informasi lebih
          lanjut.</p>
      </div>

      <div
        class="rounded-2xl overflow-hidden shadow-lg border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 h-[450px]">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.8991799473365!2d108.10032947451782!3d-7.365197072476622!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f55ac5efa0557%3A0x2161a7fb50633c91!2sKantor%20Desa%20Mangunreja!5e0!3m2!1sen!2sid!4v1767338288124!5m2!1sen!2sid"
          class="w-full h-full border-0" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>
  </section>

  {{-- GALERI --}}
  @php
    $welcomeImages = [
        asset('img/6.jpg'),
        asset('img/3.jpg'),
        asset('img/4.jpeg'),
        asset('img/2.jpg'),
        asset('img/7.jpg'),
        asset('img/8.jpg'),
        asset('img/5.jpg'),
        asset('img/1.jpg'),
    ];
  @endphp

  <section class="py-16 sm:py-24 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="max-w-3xl mx-auto text-center mb-16">
        <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
          Galeri Kegiatan
        </h2>
        <p class="mt-4 text-lg text-slate-600 dark:text-slate-400">
          Momen dan semangat para atlit Perisai Diri dalam berbagai kegiatan.
        </p>
      </div>

      {{-- Bungkus dengan komponen lightbox --}}
      <x-lightbox :images="$welcomeImages">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div class="grid gap-4">
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              {{-- Tambahkan @click di sini --}}
              <img @click="openLightbox(0)"
                class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105 cursor-pointer"
                src="{{ asset('img/6.jpg') }}" alt="Galeri Silat 1">
            </div>
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img @click="openLightbox(1)"
                class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105 cursor-pointer"
                src="{{ asset('img/3.jpg') }}" alt="Galeri Silat 2">
            </div>
          </div>
          <div class="grid gap-4">
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img @click="openLightbox(2)"
                class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105 cursor-pointer"
                src="{{ asset('img/4.jpeg') }}" alt="Galeri Silat 3">
            </div>
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img @click="openLightbox(3)"
                class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105 cursor-pointer"
                src="{{ asset('img/2.jpg') }}" alt="Galeri Silat 4">
            </div>
          </div>
          <div class="grid gap-4">
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img @click="openLightbox(4)"
                class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105 cursor-pointer"
                src="{{ asset('img/7.jpg') }}" alt="Galeri Silat 5">
            </div>
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img @click="openLightbox(5)"
                class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105 cursor-pointer"
                src="{{ asset('img/8.jpg') }}" alt="Galeri Silat 6">
            </div>
          </div>
          <div class="grid gap-4">
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img @click="openLightbox(6)"
                class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105 cursor-pointer"
                src="{{ asset('img/5.jpg') }}" alt="Galeri Silat 7">
            </div>
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img @click="openLightbox(7)"
                class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105 cursor-pointer"
                src="{{ asset('img/1.jpg') }}" alt="Galeri Silat 8">
            </div>
          </div>
        </div>
      </x-lightbox>
    </div>
  </section>

</x-app-layout>
