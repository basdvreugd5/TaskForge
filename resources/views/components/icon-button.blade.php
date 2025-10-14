@props(['icon', 'color' => 'default', 'disabled' => false, 'type' => 'button', 'size' => 'xl'])

@php
    $base = 'p-2 rounded-full transition-colors ';

    $colors = [
        'default' => 'hover:bg-slate-200 dark:hover:bg-slate-700',
        'red' => 'text-red-500 hover:bg-red-100 dark:text-red-400 dark:hover:bg-red-900/50',
        'slate' => 'text-slate-400 dark:text-slate-400',
    ];

    $classes = $base . ' ' . ($colors[$color] ?? $colors['default']);

    if ($disabled) {
        $classes .= ' opacity-50  text-slate-400 dark:text-slate-600';
    }

@endphp

<button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => $classes]) }}>
    <span class="material-symbols-outlined {{ $size === 'base' ? 'text-base' : '!text-' . $size }}">
        {{ $icon }}
    </span>
</button>
