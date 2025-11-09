<x-guest-layout>
  <!-- Session Status -->
  <x-auth-session-status class="mb-4" :status="session('status')" />

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email Address or Username (User Credentials) -->
    <div>
      <x-input-label for="user_cred" :value="__('Email or Username')" class="dark:text-white" />
      <x-text-input id="user_cred" class="block mt-1 w-full dark:text-gray-800" type="text" name="user_cred"
        :value="old('user_cred')" required autofocus autocomplete="user_cred" />
      <x-input-error :messages="$errors->get('user_cred')" class="mt-2" />
    </div>

    <!-- Password -->
    {{-- 1. Bungkus dengan x-data untuk mengelola state --}}
    <div class="mt-4" x-data="{ show: false }">
      <x-input-label for="password" :value="__('Password')" class="dark:text-white" />

      {{-- 2. Tambahkan div relatif untuk menampung ikon --}}
      <div class="relative">
        <x-text-input id="password" class="block mt-1 w-full pr-10 dark:text-gray-800" x-bind:type="show ? 'text' : 'password'"
          {{-- 3. Bind tipe input ke state 'show' --}} name="password" required autocomplete="current-password" />

        {{-- 4. Tombol ikon absolut di sebelah kanan --}}
        <button type="button" @click="show = !show"
          class="absolute inset-y-0 right-0 pr-3 mr-3 flex items-center text-gray-400 dark:text-gray-500">
          <span class="sr-only">Show/hide password</span>

          {{-- Ikon Mata (tersembunyi) --}}
          <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
          </svg>

          {{-- Ikon Mata Tercoret (tampil) --}}
          <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-5" style="display: none;">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.243 4.243-4.243-4.243" />
          </svg>
        </button>
      </div>
      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Remember Me -->
    <div class="block mt-4">
      <label for="remember_me" class="inline-flex items-center">
        <input id="remember_me" type="checkbox" class="rounded-sm border-gray-300 text-indigo-600 shadow-xs"
          name="remember">
        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
      </label>
    </div>

    <div class="flex items-center justify-end mt-4">
      @if (Route::has('password.request'))
        <a class="underline text-sm text-gray-400 hover:text-gray-600 rounded-md focus:outline-hidden focus:ring-2 focus:ring-offset-2"
          href="{{ route('password.request') }}">
          {{ __('Forgot your password?') }}
        </a>
      @endif

      <x-primary-button class="ms-3">
        {{ __('Log in') }}
      </x-primary-button>
    </div>

    <div class="text-center mt-6">
      <span class="text-sm text-gray-600 dark:text-gray-400">
        {{ __("Don't have an account?") }}
      </span>
      <a class="underline text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-200 rounded-md"
        href="{{ route('register') }}">
        {{ __('Register here') }}
      </a>
    </div>
  </form>
</x-guest-layout>
