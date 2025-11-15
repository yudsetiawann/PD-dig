<x-guest-layout>
    {{--
      Catatan: Desain ini mengasumsikan 'x-guest-layout' menyediakan
      kartu/wrapper <div class="w-full sm:max-w-md ..."> seperti
      layout auth bawaan Laravel.
    --}}

    <!-- Judul -->
    <h2 class="-mt-6 text-center text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
      Buat Akun Baru
    </h2>
    <p class="mt-2 text-center text-sm text-slate-600 dark:text-slate-400">
      Isi data di bawah untuk mendaftar.
    </p>

    <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
      @csrf

      <!-- Name -->
      <div>
        <x-input-label for="name" :value="__('Name')"
          class="block text-sm font-medium text-slate-700 dark:text-slate-300" />
        <x-text-input id="name"
          class="block mt-1 w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-600 focus:ring-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:focus:border-blue-500"
          type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
      </div>

      <!-- Username -->
      <div>
        <x-input-label for="username" :value="__('Username')"
          class="block text-sm font-medium text-slate-700 dark:text-slate-300" />
        <x-text-input id="username"
          class="block mt-1 w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-600 focus:ring-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:focus:border-blue-500"
          type="text" name="username" :value="old('username')" required autocomplete="username" />
        <x-input-error :messages="$errors->get('username')" class="mt-2" />
      </div>

      <!-- Email Address -->
      <div>
        <x-input-label for="email" :value="__('Email')"
          class="block text-sm font-medium text-slate-700 dark:text-slate-300" />
        <x-text-input id="email"
          class="block mt-1 w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-600 focus:ring-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:focus:border-blue-500"
          type="email" name="email" :value="old('email')" required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>

      <!-- Password -->
      <div x-data="{ show: false }">
        <x-input-label for="password" :value="__('Password')"
          class="block text-sm font-medium text-slate-700 dark:text-slate-300" />
        <div class="relative">
          <x-text-input id="password"
            class="block mt-1 w-full pr-10 rounded-lg border-slate-300 shadow-sm focus:border-blue-600 focus:ring-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:focus:border-blue-500"
            x-bind:type="show ? 'text' : 'password'" name="password" required autocomplete="new-password" />
          <button type="button" @click="show = !show"
            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300">
            <span class="sr-only">Show/hide password</span>
            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke-width="1.5" stroke="currentColor" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke-width="1.5" stroke="currentColor" class="size-5" style="display: none;">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.243 4.243-4.243-4.243" />
            </svg>
          </button>
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
      </div>

      <!-- Confirm Password -->
      <div x-data="{ show: false }">
        <x-input-label for="password_confirmation" :value="__('Confirm Password')"
          class="block text-sm font-medium text-slate-700 dark:text-slate-300" />
        <div class="relative">
          <x-text-input id="password_confirmation"
            class="block mt-1 w-full pr-10 rounded-lg border-slate-300 shadow-sm focus:border-blue-600 focus:ring-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:focus:border-blue-500"
            x-bind:type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" />
          <button type="button" @click="show = !show"
            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300">
            <span class="sr-only">Show/hide password</span>
            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke-width="1.5" stroke="currentColor" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke-width="1.5" stroke="currentColor" class="size-5" style="display: none;">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.243 4.243-4.243-4.243" />
            </svg>
          </button>
        </div>
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
      </div>

      <!-- Tombol Register -->
      <div class="pt-2">
        <x-primary-button class="w-full flex justify-center">
          {{ __('Register') }}
        </x-primary-button>
      </div>
    </form>

    <!-- Link Login -->
    <div class="mt-6 text-center text-sm">
      <span class="text-slate-600 dark:text-slate-400">
        {{ __('Sudah punya akun?') }}
      </span>
      <a class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300"
        href="{{ route('login') }}">
        {{ __('Masuk di sini') }}
      </a>
    </div>
  </x-guest-layout>
