<section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5 dark:bg-slate-800 dark:ring-white/10 sm:p-8">

  {{-- Header Section --}}
  <header class="flex items-start gap-4 mb-8">
    <div
      class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-900/20 dark:text-indigo-400">
      {{-- Ikon Kunci/Keamanan --}}
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
      </svg>
    </div>
    <div>
      <h2 class="text-lg font-bold text-slate-900 dark:text-white">
        {{ __('Perbarui Kata Sandi') }}
      </h2>
      <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
        {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}
      </p>
    </div>
  </header>

  <form method="post" action="{{ route('password.update') }}" class="space-y-6">
    @csrf
    @method('put')

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
      {{-- Current Password --}}
      <div class="col-span-1 md:col-span-2" x-data="{ show: false }">
        <x-input-label for="update_password_current_password" :value="__('Password Saat Ini')"
          class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300" />
        <div class="relative">
          <x-text-input id="update_password_current_password" name="current_password" type="password"
            class="block w-full rounded-lg border-slate-300 pr-10 shadow-sm focus:border-indigo-600 focus:ring-indigo-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white"
            autocomplete="current-password" x-bind:type="show ? 'text' : 'password'" />

          <button type="button" @click="show = !show"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300">
            <span class="sr-only">Show/hide password</span>
            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            <svg x-show="show" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.243 4.243-4.243-4.243" />
            </svg>
          </button>
        </div>
        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
      </div>

      {{-- New Password --}}
      <div class="col-span-1" x-data="{ show: false }">
        <x-input-label for="update_password_password" :value="__('Password Baru')"
          class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300" />
        <div class="relative">
          <x-text-input id="update_password_password" name="password" type="password"
            class="block w-full rounded-lg border-slate-300 pr-10 shadow-sm focus:border-indigo-600 focus:ring-indigo-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white"
            autocomplete="new-password" x-bind:type="show ? 'text' : 'password'" />

          <button type="button" @click="show = !show"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300">
            <span class="sr-only">Show/hide password</span>
            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            <svg x-show="show" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.243 4.243-4.243-4.243" />
            </svg>
          </button>
        </div>
        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
      </div>

      {{-- Confirm Password --}}
      <div class="col-span-1" x-data="{ show: false }">
        <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Password')"
          class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300" />
        <div class="relative">
          <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
            class="block w-full rounded-lg border-slate-300 pr-10 shadow-sm focus:border-indigo-600 focus:ring-indigo-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white"
            autocomplete="new-password" x-bind:type="show ? 'text' : 'password'" />

          <button type="button" @click="show = !show"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300">
            <span class="sr-only">Show/hide password</span>
            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke-width="1.5" stroke="currentColor" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            <svg x-show="show" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.243 4.243-4.243-4.243" />
            </svg>
          </button>
        </div>
        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
      </div>
    </div>

    {{-- Footer --}}
    <div class="flex items-center gap-4 border-t border-slate-100 pt-6 dark:border-slate-700">
      <x-primary-button class="px-6 py-2.5">{{ __('Simpan Password') }}</x-primary-button>

      @if (session('status') === 'password-updated')
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
          {{ __('Berhasil diperbarui.') }}
        </div>
      @endif
    </div>
  </form>
</section>
