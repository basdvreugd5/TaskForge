@props(['color' => 'slate'])

<span @class([
    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
    "bg-{$color}-100 dark:bg-{$color}-700 text-{$color}-800 dark:text-{$color}-300",
])>
    {{ $slot }}
</span>
