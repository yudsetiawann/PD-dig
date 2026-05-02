@props(['timeout' => 5000])

@if (session()->has('message') || session()->has('error'))
    @php
        $isError = session()->has('error');
        $message = session('message') ?? session('error');
        $colorBar = $isError ? 'border-red-500' : 'border-green-500';
        $iconColor = $isError ? 'text-red-400' : 'text-green-400';
        $title = $isError ? 'Terjadi Kesalahan' : 'Berhasil!';
        $iconPath = $isError
            ? 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z'
            : 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
    @endphp

    <div x-data="{ show: true }" x-show="show" x-transition:enter="transform ease-out duration-300"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, {{ $timeout }})"
        class="fixed top-24 right-5 z-50 w-full max-w-sm bg-white dark:bg-gray-800 border-l-4 {{ $colorBar }} shadow-xl rounded-lg">
        <div class="p-4 flex items-start gap-3">
            <svg class="h-6 w-6 shrink-0 {{ $iconColor }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}" />
            </svg>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $title }}</p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $message }}</p>
            </div>
            <button @click="show = false" class="text-gray-400 hover:text-gray-600">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                </svg>
            </button>
        </div>
    </div>
@endif
