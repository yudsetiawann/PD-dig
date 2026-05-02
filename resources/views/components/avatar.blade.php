{{-- resources/views/components/avatar.blade.php --}}
@props(['model'])

<div {{ $attributes->merge(['class' => 'flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-100 text-lg font-bold text-slate-600 dark:bg-slate-700 dark:text-slate-300']) }}>
    @if ($model->getFirstMediaUrl('profile_photo'))
        {{-- Ubah h-9 w-9 menjadi h-full w-full --}}
        <img src="{{ $model->getFirstMediaUrl('profile_photo') }}" alt="Profile Photo"
             class="h-full w-full rounded-full object-cover">
    @else
        {{-- Ubah h-9 w-9 menjadi h-full w-full --}}
        <span class="inline-flex h-full w-full items-center justify-center rounded-full bg-blue-600 text-white">
            <span class="text-sm font-medium leading-none">
                {{ strtoupper(substr($model->name, 0, 1)) }}
            </span>
        </span>
    @endif
</div>
