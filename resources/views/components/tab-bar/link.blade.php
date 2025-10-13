@props([
    'href' => '#',
    'label',
    'active' => false,
])

<a href="{{ $href }}"
    {{ $attributes->class([
        'flex items-center justify-center border-b-2  transition-colors pb-3',
        $active
            ? 'border-primary text-primary'
            : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary hover:border-primary/50',
    ]) }}>
    <p class="text-sm font-bold">{{ $label }}</p>
</a>
