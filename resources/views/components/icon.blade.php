@props([
    'color' => 'slate',
    'size' => 'md',
    'class' => '',
])

@php
    $colorClasses = '';
@endphp

@switch($color)
    @case('teal')
        @php $colorClass = 'bg-teal-100 dark:bg-teal-700/50 text-teal-800 dark:text-teal-300'; @endphp
    @break

    @case('blue')
        @php $colorClass = 'bg-blue-100 dark:bg-blue-700/50 text-blue-800 dark:text-blue-300'; @endphp
    @break

    @case('green')
        @php $colorClass = 'bg-green-100 dark:bg-green-700 text-green-800 dark:text-green-300'; @endphp
    @break

    @case('purple')
        @php $colorClass = 'bg-purple-100 dark:bg-purple-700/50 text-purple-800 dark:text-purple-300'; @endphp
    @break

    @case('yellow')
        @php $colorClass = 'bg-yellow-100 dark:bg-yellow-900/50 text-yellow -800 dark:text-yellow-300'; @endphp
    @break

    @case('red')
        @php $colorClass = 'bg-red-100 dark:bg-red-700 text-red-800 dark:text-red-300';  @endphp
    @break

    @default
        @php $colorClass = "bg-{$color}-100 dark:bg-{$color}-700/50 text-{$color}-800 dark:text-{$color}-300";   @endphp
@endswitch

@switch($size)
    @case('sm')
        @php
            $sizeClass = 'text-xs px-2 py-0.5';
        @endphp
    @break

    @case('lg')
        @php
            $sizeClass = 'text-base px-4 py-1.5';
        @endphp
    @break

    @case('md')

        @default
            @php
                $sizeClass = 'text-sm px-3 py-1';
            @endphp
        @break
    @endswitch

    @php
        $finalClasses = trim($sizeClass . ' ' . $colorClass . ' ' . $class);
    @endphp

    <span {{ $attributes->merge(['class' => "rounded-full text-sm font-medium $finalClasses"]) }}>
        {{ $slot }}
    </span>
