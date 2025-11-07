<x-app-layout> {{-- Menggunakan layout layouts/app.blade.php --}}
  <x-slot name="header">
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
      Selamat Datang!
    </h1>
  </x-slot>

  {{-- Konten Utama Halaman Depan Anda --}}
  <section class="mb-12 relative">
    <div class="absolute inset-0">
      <img src="{{ asset('img/PD-hero.jpg') }}" alt="Atlit Pencak Silat" loading="lazy" class="w-full h-full object-cover">
      <div class="absolute inset-0 bg-slate-900/60 mix-blend-multiply"></div>
    </div>

    <div class="relative container mx-auto px-4 sm:px-6 lg:px-8 py-32 md:py-48 text-center">
      <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight">
        Platform Tiket Resmi Perisai Diri
      </h1>
      <p class="mt-6 text-lg md:text-xl text-gray-200 max-w-3xl mx-auto">
        Temukan dan beli tiket untuk berbagai kejuaraan, ujian kenaikan tingkat, dan event lainnya di Perisai Diri cabang kabupaten Tasikmalaya.
      </p>
      <div class="mt-10">
        <a href="/events"
          class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg text-lg shadow-lg hover:scale-105 transition duration-200">
          Lihat Semua Event
        </a>
      </div>
    </div>
  </section>

  {{-- Event Mendatang --}}
  {{-- <section class="py-16 sm:py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-3xl font-bold text-center text-white mb-12">
        Event Mendatang
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        <div class="bg-slate-800 rounded-lg shadow-xl overflow-hidden flex flex-col">
          <img class="h-56 w-full object-cover"
            src="https://images.unsplash.com/photo-1593348121683-936d5b38e4c7?fit=crop&w=600&h=400&q=80"
            alt="Poster Event Ujian Kenaikan Tingkat">
          <div class="p-6 flex flex-col grow">
            <h3 class="text-xl font-semibold text-white mb-2">Ujian Kenaikan Tingkat</h3>
            <p class="text-gray-400 text-sm mb-1">Gedung Pramuka</p>
            <p class="text-gray-400 text-sm mb-4">27 Oct 2025</p>
            <p class="text-lg font-bold text-white mb-5">Rp 50.000 - Rp 80.000</p>
            <div class="mt-auto">
              <a href="#"
                class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300">
                Lihat Detail
              </a>
            </div>
          </div>
        </div>

        <div class="bg-slate-800 rounded-lg shadow-xl overflow-hidden flex flex-col">
          <img class="h-56 w-full object-cover"
            src="https://images.unsplash.com/photo-1581005963842-b08ef0694e9f?fit=crop&w=600&h=400&q=80"
            alt="Poster Event Perisai Diri Cup">
          <div class="p-6 flex flex-col grow">
            <h3 class="text-xl font-semibold text-white mb-2">Perisai Diri Cup</h3>
            <p class="text-gray-400 text-sm mb-1">Gedung Pramuka</p>
            <p class="text-gray-400 text-sm mb-4">29 Oct 2025</p>
            <p class="text-lg font-bold text-white mb-5">Rp 200.000</p>
            <div class="mt-auto">
              <a href="#"
                class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300">
                Lihat Detail
              </a>
            </div>
          </div>
        </div>

        <div class="bg-slate-800 rounded-lg shadow-xl overflow-hidden flex flex-col">
          <img class="h-56 w-full object-cover"
            src="https://images.unsplash.com/photo-1579487785973-74d2ca7abdd5?fit=crop&w=600&h=400&q=80"
            alt="Poster Event Kejuaraan Nasional">
          <div class="p-6 flex flex-col grow">
            <h3 class="text-xl font-semibold text-white mb-2">Kejuaraan Nasional</h3>
            <p class="text-gray-400 text-sm mb-1">GOR Saparua, Bandung</p>
            <p class="text-gray-400 text-sm mb-4">15 Nov 2025</p>
            <p class="text-lg font-bold text-white mb-5">Rp 350.000</p>
            <div class="mt-auto">
              <a href="#"
                class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300">
                Lihat Detail
              </a>
            </div>
          </div>
        </div>

      </div>

      <div class="text-center mt-12">
        <a href="#"
          class="inline-block bg-slate-700 hover:bg-slate-600 text-gray-200 font-semibold py-3 px-6 rounded-lg transition duration-300">
          Muat Lebih Banyak Event
        </a>
      </div>
    </div>
  </section> --}}
  {{-- End Event Mendatang --}}

  <section class="py-16 sm:py-20 bg-slate-600 dark:bg-slate-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-3xl font-bold text-center text-white mb-16">
        Cara Memesan Tiket
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

        <div class="text-center">
          <div class="flex items-center justify-center h-16 w-16 bg-blue-600/20 rounded-full mx-auto mb-5">
            <svg class="h-8 w-8 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-white mb-2">1. Pilih Event</h3>
          <p class="text-gray-400">Temukan event yang Anda inginkan dari daftar event yang tersedia.</p>
        </div>

        <div class="text-center">
          <div class="flex items-center justify-center h-16 w-16 bg-blue-600/20 rounded-full mx-auto mb-5">
            <svg class="h-8 w-8 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-white mb-2">2. Isi Data Diri</h3>
          <p class="text-gray-400">Lengkapi data diri Anda sesuai formulir pemesanan tiket.</p>
        </div>

        <div class="text-center">
          <div class="flex items-center justify-center h-16 w-16 bg-blue-600/20 rounded-full mx-auto mb-5">
            <svg class="h-8 w-8 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h6m-6 2.25h6M12 9v10.5m3.75-10.5H21a.75.75 0 0 0 .75-.75V7.5a.75.75 0 0 0-.75-.75H15.75m0 3H21m-3.75 0v10.5m0-10.5h-3.75m3.75 0h3.75M12 3v3.75m0 0h-3.75m3.75 0h3.75M12 3V.75" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-white mb-2">3. Bayar Aman</h3>
          <p class="text-gray-400">Lakukan pembayaran dengan metode yang Anda pilih melalui payment gateway.</p>
        </div>

        <div class="text-center">
          <div class="flex items-center justify-center h-16 w-16 bg-blue-600/20 rounded-full mx-auto mb-5">
            <svg class="h-8 w-8 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-1.5h5.25m-5.25 0h5.25m-5.25 0h5.25m-5.25 0h5.25M3 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25H3a2.25 2.25 0 0 1-2.25-2.25V6.75A2.25 2.25 0 0 1 3 4.5Z" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-white mb-2">4. Dapatkan E-Ticket</h3>
          <p class="text-gray-400">E-Ticket akan tersedia di halaman 'Tiket Saya'.</p>
        </div>

      </div>
    </div>
  </section>

  <section class="py-16 sm:py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-16">
        Kenapa Memilih E-Tick PD?
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

        <div class="text-center md:text-left">
          <svg class="h-10 w-10 text-blue-600 dark:text-blue-400 mb-4 mx-auto md:mx-0"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.623 0-1.31-.21-2.571-.6-3.751A11.959 11.959 0 0 1 12 2.714Z" />
          </svg>
          <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-2">Pembayaran Aman</h3>
          <p class="text-gray-600 dark:text-gray-400">Didukung oleh payment gateway terpercaya untuk menjamin keamanan
            transaksi Anda.</p>
        </div>

        <div class="text-center md:text-left">
          <svg class="h-10 w-10 text-blue-600 dark:text-blue-400 mb-4 mx-auto md:mx-0"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-1.5h5.25m-5.25 0h5.25m-5.25 0h5.25m-5.25 0h5.25M3 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25H3a2.25 2.25 0 0 1-2.25-2.25V6.75A2.25 2.25 0 0 1 3 4.5Z" />
          </svg>
          <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-2">Tiket Resmi & Valid</h3>
          <p class="text-gray-600 dark:text-gray-400">Platform resmi yang bekerja sama langsung dengan panitia
            penyelenggara event.</p>
        </div>

        <div class="text-center md:text-left">
          <svg class="h-10 w-10 text-blue-600 dark:text-blue-400 mb-4 mx-auto md:mx-0"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
          </svg>
          <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-2">Proses Instan</h3>
          <p class="text-gray-600 dark:text-gray-400">E-Ticket dengan QR Code unik diterbitkan otomatis setelah
            pembayaran berhasil.</p>
        </div>

      </div>
    </div>
  </section>

  <section class="py-16 sm:py-20 bg-slate-600 dark:bg-slate-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-3xl font-bold text-center text-white mb-12">
        Galeri Kegiatan
      </h2>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="grid gap-4">
          <div>
            <img class="h-auto max-w-full rounded-lg shadow-lg hover:scale-110 transition-transform duration-300"
              src="{{ asset('img/6.jpg') }}" alt="Galeri Silat 1">
          </div>
          <div>
            <img class="h-auto max-w-full rounded-lg shadow-lg hover:scale-110 transition-transform duration-300"
              src="{{ asset('img/3.jpg') }}" alt="Galeri Silat 2">
          </div>
        </div>
        <div class="grid gap-4">
          <div>
            <img class="h-auto max-w-full rounded-lg shadow-lg hover:scale-110 transition-transform duration-300"
              src="{{ asset('img/4.jpeg') }}" alt="Galeri Silat 3">
          </div>
          <div>
            <img class="h-auto max-w-full rounded-lg shadow-lg hover:scale-110 transition-transform duration-300"
              src="{{ asset('img/2.jpg') }}" alt="Galeri Silat 4">
          </div>
        </div>
        <div class="grid gap-4">
          <div>
            <img class="h-auto max-w-full rounded-lg shadow-lg hover:scale-110 transition-transform duration-300"
              src="{{ asset('img/7.jpg') }}" alt="Galeri Silat 5">
          </div>
          <div>
            <img class="h-auto max-w-full rounded-lg shadow-lg hover:scale-110 transition-transform duration-300"
              src="{{ asset('img/8.jpg') }}" alt="Galeri Silat 6">
          </div>
        </div>
        <div class="grid gap-4">
          <div>
            <img class="h-auto max-w-full rounded-lg shadow-lg hover:scale-110 transition-transform duration-300"
              src="{{ asset('img/5.jpg') }}" alt="Galeri Silat 7">
          </div>
          <div>
            <img class="h-auto max-w-full rounded-lg shadow-lg hover:scale-110 transition-transform duration-300"
              src="{{ asset('img/1.jpg') }}" alt="Galeri Silat 8">
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-16 sm:py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h2 class="text-3xl font-bold text-gray-800 dark:text-white sm:text-4xl">
        Jangan Ketinggalan Event Berikutnya!
      </h2>
      <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
        Daftar dan dapatkan tiket Anda untuk menjadi bagian dari semangat Perisai Diri.
      </p>
      <div class="mt-8">
        <a href="/events"
          class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg text-lg shadow-lg hover:scale-105 transition duration-200">
          Cari Event Sekarang
        </a>
      </div>
    </div>
  </section>

</x-app-layout>
