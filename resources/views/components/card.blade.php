@props([
    'variant' => 'default',
    'class' => '',
])

@php
    $baseClasses = 'rounded-lg shadow-sm transition-shadow duration-300';
    $variantClasses = '';
@endphp

@switch($variant)
    @case('form')
        @php
            $variantClasses = 'bg-white dark:bg-card-dark shadow-lg p-8 md:p-12 space-y-12';
        @endphp
    @break

    @case('wide')
        @php
            $variantClasses = 'bg-card-light dark:bg-card-dark w-full max-w-2xl shadow-xl mx-auto my-24';
        @endphp
    @break

    @case('board')
        @php
            $variantClasses =
                'p-5 border-2 flex flex-col gap-4 bg-card-light dark:bg-card-dark hover:shadow-lg min-h-[280px]';
        @endphp
    @break

    @default
        @php
            $variantClasses =
                'p-5 border-2 flex flex-col gap-4 bg-card-light dark:bg-card-dark hover:shadow-lg min-h-[280px]';
        @endphp
    @break
@endswitch

@php
    $finalClasses = trim($baseClasses . ' ' . $variantClasses . ' ' . $class);
@endphp

<div {{ $attributes->merge(['class' => $finalClasses]) }}>
    {{ $slot }}
</div>
