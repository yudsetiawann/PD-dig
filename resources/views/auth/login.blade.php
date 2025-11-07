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
    <div class="mt-4">
      <x-input-label for="password" :value="__('Password')" class="dark:text-white" />

      <x-text-input id="password" class="block mt-1 w-full dark:text-gray-800" type="password" name="password" required
        autocomplete="current-password" />

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
