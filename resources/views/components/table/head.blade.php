<thead
    {{ $attributes->merge([
        'class' => 'bg-slate-50 dark:bg-card-dark/80 text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider',
    ]) }}>
    {{ $slot }}
</thead>
