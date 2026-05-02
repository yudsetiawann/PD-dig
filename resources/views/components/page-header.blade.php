@props([
    'title'       => null,   // null = tidak tampilkan heading (mode search-only)
    'breadcrumbs' => [],
    'search'      => false,
    'placeholder' => 'Cari...',
])

<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    @if($title !== null || count($breadcrumbs))
    <div>
        @if($title !== null)
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $title }}</h2>
        @endif
        @if(count($breadcrumbs))
        <nav class="flex text-sm text-slate-500 dark:text-slate-400 mt-1" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                @foreach($breadcrumbs as $crumb)
                    @if(!$loop->last)
                        <li><a href="{{ $crumb['url'] }}" class="hover:text-blue-600">{{ $crumb['label'] }}</a></li>
                        <li><span class="text-slate-400">/</span></li>
                    @else
                        <li class="font-medium text-slate-900 dark:text-white">{{ $crumb['label'] }}</li>
                    @endif
                @endforeach
            </ol>
        </nav>
        @endif
    </div>
    @endif

    @if($search)
    <div class="relative w-full md:w-64">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="{{ $placeholder }}"
            class="w-full rounded-lg border-slate-300 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-700 dark:text-white">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/>
            </svg>
        </div>
    </div>
    @endif
</div>
