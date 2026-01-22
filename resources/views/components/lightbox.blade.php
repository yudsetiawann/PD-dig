{{--
  Komponen ini akan:
  - Menerima daftar gambar (images)
  - Menggunakan Alpine.js untuk menampilkan modal saat gambar diklik
  - Menampilkan backdrop blur
--}}
@props(['images' => []])

<div x-data="{
    open: false,
    activeImage: null,
    {{-- Ubah inisialisasi jadi null atau object kosong --}}
    images: {{ json_encode($images) }},
    activeIndex: 0,

    openLightbox(index) {
        this.activeIndex = index;
        this.activeImage = this.images[index];
        this.open = true;
    },

    closeLightbox() {
        this.open = false;
        {{-- Opsional: reset activeImage agar bersih saat dibuka lagi, tapi tidak wajib --}}
    },

    nextImage() {
        this.activeIndex = (this.activeIndex + 1) % this.images.length;
        this.activeImage = this.images[this.activeIndex];
    },

    prevImage() {
        this.activeIndex = (this.activeIndex - 1 + this.images.length) % this.images.length;
        this.activeImage = this.images[this.activeIndex];
    }
}">

  {{ $slot }}

  <div x-cloak x-show="open" @keydown.escape.window="closeLightbox"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    {{-- Backdrop --}}
    <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0" @click="closeLightbox" class="absolute inset-0 bg-black/90 backdrop-blur-sm">
    </div>

    {{-- Modal Content --}}
    <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
      x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
      x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
      class="relative max-w-5xl max-h-[90vh] w-full flex flex-col items-center">

      {{--
          PERBAIKAN UTAMA DI SINI:
          1. Tambahkan pengecekan 'activeImage' (untuk mencegah error saat init)
          2. Gunakan .src untuk mengambil URL
          3. Gunakan .alt untuk teks alternatif
      --}}
      <template x-if="activeImage">
        <div class="relative w-full h-full flex flex-col items-center">
          <img :src="activeImage.src" :alt="activeImage.alt"
            class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-2xl">

          {{-- Menampilkan Caption (Alt Text) --}}
          <p x-text="activeImage.alt" class="text-gray-300 mt-4 text-center font-medium text-lg"></p>
        </div>
      </template>

      {{-- Tombol Close --}}
      <button @click="closeLightbox"
        class="absolute -top-10 right-0 sm:top-0 sm:-right-12 text-white bg-white/10 hover:bg-white/20 rounded-full p-2 focus:outline-none transition z-50">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      {{-- Navigasi --}}
      <template x-if="images.length > 1">
        <div>
          <button @click="prevImage"
            class="absolute top-1/2 left-0 sm:-left-16 transform -translate-y-1/2 text-white hover:text-gray-300 focus:outline-none transition p-2">
            <svg class="w-10 h-10 drop-shadow-lg" fill="none" viewBox="0 0 24 24" stroke-width="2"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
          </button>

          <button @click="nextImage"
            class="absolute top-1/2 right-0 sm:-right-16 transform -translate-y-1/2 text-white hover:text-gray-300 focus:outline-none transition p-2">
            <svg class="w-10 h-10 drop-shadow-lg" fill="none" viewBox="0 0 24 24" stroke-width="2"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
          </button>
        </div>
      </template>

    </div>
  </div>
</div>
