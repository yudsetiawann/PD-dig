<section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5 dark:bg-slate-800 dark:ring-white/10 sm:p-8">

  {{-- Header Section dengan Ikon --}}
  <header class="flex items-start gap-4 mb-8">
    <div
      class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400">
      {{-- Ikon User --}}
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A1.875 1.875 0 0 1 18 22.5H6A1.875 1.875 0 0 1 4.501 20.118Z" />
      </svg>
    </div>
    <div>
      <h2 class="text-lg font-bold text-slate-900 dark:text-white">
        {{ __('Informasi Profil') }}
      </h2>
      <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
        {{ __('Perbarui informasi profil akun dan alamat email Anda.') }}
      </p>
    </div>
  </header>

  {{-- Form Verifikasi (Hidden) --}}
  <form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
  </form>

  {{-- Form Update Utama --}}
  <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
    @csrf
    @method('patch')

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
      {{-- Input Name --}}
      <div class="col-span-1">
        <x-input-label for="name" :value="__('Nama Lengkap')"
          class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300" />
        <x-text-input id="name" name="name" type="text"
          class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-600 focus:ring-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white"
          :value="old('name', $user->name)" required autofocus autocomplete="name" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
      </div>

      {{-- Input Username --}}
      <div class="col-span-1">
        <x-input-label for="username" :value="__('Username')"
          class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300" />
        <x-text-input id="username" name="username" type="text"
          class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-600 focus:ring-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white"
          :value="old('username', $user->username)" required autocomplete="username" />
        <x-input-error class="mt-2" :messages="$errors->get('username')" />
      </div>

      {{-- Input Email (Full Width) --}}
      <div class="col-span-1 md:col-span-2">
        <x-input-label for="email" :value="__('Email')"
          class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300" />
        <x-text-input id="email" name="email" type="email"
          class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-600 focus:ring-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white"
          :value="old('email', $user->email)" required autocomplete="username" />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />

        {{-- Bagian Verifikasi Email --}}
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
          <div
            class="mt-4 rounded-lg border border-amber-200 bg-amber-50 p-4 dark:border-amber-800 dark:bg-amber-900/20">
            <div class="flex items-start gap-3">
              <svg class="size-5 shrink-0 text-amber-600 dark:text-amber-500" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                  d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                  clip-rule="evenodd" />
              </svg>
              <div>
                <p class="text-sm text-amber-800 dark:text-amber-200">
                  {{ __('Alamat email Anda belum diverifikasi.') }}
                </p>
                <button form="send-verification"
                  class="mt-1 text-sm font-medium text-amber-800 underline hover:text-amber-900 dark:text-amber-200 dark:hover:text-white focus:outline-none">
                  {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                </button>

                @if (session('status') === 'verification-link-sent')
                  <p class="mt-2 text-sm font-semibold text-green-600 dark:text-green-400">
                    {{ __('Tautan verifikasi baru telah dikirim ke email Anda.') }}
                  </p>
                @endif
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>

    {{-- Footer Aksi --}}
    <div class="flex items-center gap-4 border-t border-slate-100 pt-6 dark:border-slate-700">
      <x-primary-button class="px-6 py-2.5">
        {{ __('Simpan Perubahan') }}
      </x-primary-button>

      @if (session('status') === 'profile-updated')
        <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 transform translate-x-2"
          x-transition:enter-end="opacity-100 transform translate-x-0"
          x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
          x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 2000)"
          class="flex items-center gap-2 text-sm font-medium text-green-600 dark:text-green-400">
          <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
              d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
              clip-rule="evenodd" />
          </svg>
          {{ __('Berhasil disimpan.') }}
        </div>
      @endif
    </div>
  </form>
</section>
