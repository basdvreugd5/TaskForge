@props(['icon' => null, 'type' => 'button', 'variant' => 'default'])

@php
    $variants = [
        'default' =>
            'text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary hover:bg-slate-100 dark:hover:bg-slate-800',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
        'success' => 'bg-green-600 text-white hover:bg-green-700',
    ];
@endphp

<button type="{{ $type }}"
    {{ $attributes->class([
        'flex items-center gap-2 text-sm font-medium rounded-lg px-3 py-1.5 -my-1.5 -mx-3 transition-colors duration-300',
        $variants[$variant] ?? $variants['default'],
    ]) }}>
    @if ($icon)
        <span class="material-symbols-outlined text-base">{{ $icon }}</span>
    @endif
    {{ $slot }}
</button>
