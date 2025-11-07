<x-guest-layout>
  <div class="mb-4 text-sm text-gray-600 dark:text-gray-100">
    {{ __('Lupa kata sandi? Tidak masalah. Cukup beri tahu kami alamat email Anda, dan kami akan mengirimkan tautan pengaturan ulang kata sandi melalui email agar Anda dapat memilih kata sandi baru.') }}
  </div>

  <!-- Session Status -->
  <x-auth-session-status class="mb-4" :status="session('status')" />

  <form method="POST" action="{{ route('password.email') }}">
    @csrf

    <!-- Email Address -->
    <div>
      <x-input-label for="email" :value="__('Email')" class="dark:text-gray-100" />
      <x-text-input id="email" class="block mt-1 w-full dark:text-gray-800" type="email" name="email" :value="old('email')" required
        autofocus />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">
      <x-primary-button>
        {{ __('Kirim Ulang Kata Sandi') }}
      </x-primary-button>
    </div>
  </form>
</x-guest-layout>
