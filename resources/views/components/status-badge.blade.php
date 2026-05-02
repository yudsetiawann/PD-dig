@props([
    'variant' => 'default', // default|blue|green|yellow|red|indigo|slate
    'size' => 'sm', // sm|xs
])

@php
    $variants = [
        'default' => 'bg-slate-100 text-slate-700 ring-slate-500/10 dark:bg-slate-700 dark:text-slate-300',
        'blue' => 'bg-blue-50 text-blue-700 ring-blue-700/10 dark:bg-blue-900/30 dark:text-blue-400',
        'green' => 'bg-green-50 text-green-700 ring-green-600/10 dark:bg-green-900/30 dark:text-green-400',
        'yellow' => 'bg-yellow-50 text-yellow-700 ring-yellow-600/10 dark:bg-yellow-900/30 dark:text-yellow-400',
        'red' => 'bg-red-50 text-red-700 ring-red-600/10 dark:bg-red-900/30 dark:text-red-400',
        'indigo' => 'bg-indigo-50 text-indigo-700 ring-indigo-700/10 dark:bg-indigo-900/30 dark:text-indigo-400',
    ];
    $sizes = [
        'sm' => 'px-2.5 py-0.5 text-xs',
        'xs' => 'px-2 py-1 text-[10px]',
    ];
@endphp

<span
    {{ $attributes->merge([
        'class' =>
            'inline-flex items-center rounded-full font-medium ring-1 ring-inset ' .
            ($variants[$variant] ?? $variants['default']) .
            ' ' .
            ($sizes[$size] ?? $sizes['sm']),
    ]) }}>
    {{ $slot }}
</span>
