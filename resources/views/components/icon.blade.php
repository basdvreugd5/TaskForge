@props([
    'color' => 'slate',
    'size' => 'md',
    'class' => '',
    'icon' => null,
    'variant' => null,
])

@php
    $colorClasses = '';
@endphp

@switch($color)
    @case('teal')
        @php $colorClass = 'text-teal-800 dark:text-teal-300'; @endphp
    @break

    @case('blue')
        @php $colorClass = 'text-blue-800 dark:text-blue-300'; @endphp
    @break

    @case('green')
        @php $colorClass = 'text-green-800 dark:text-green-300'; @endphp
    @break

    @case('purple')
        @php $colorClass = 'text-purple-800 dark:text-purple-300'; @endphp
    @break

    @case('yellow')
        @php $colorClass = 'text-yellow -800 dark:text-yellow-300'; @endphp
    @break

    @case('red')
        @php $colorClass = 'text-red-800 dark:text-red-300';  @endphp
    @break

    @case('amber')
        @php $colorClass = 'text-amber-500 dark:text-amber-300';  @endphp
    @break

    @default
        @php $colorClass = "bg-{$color}-100 dark:bg-{$color}-700/50 text-{$color}-800 dark:text-{$color}-300";   @endphp
@endswitch

@switch($size)
    @case('sm')
        @php
            $sizeClass = 'text-xs';
        @endphp
    @break

    @case('lg')
        @php
            $sizeClass = 'text-base';
        @endphp
    @break

    @case('md')

        @default
            @php
                $sizeClass = 'text-sm';
            @endphp
        @break
    @endswitch

    {{-- Icon Logic --}}
    @switch($icon)
        @case(task_alt)
        @break

        @default
    @endswitch

    @php
        $finalClasses = trim($sizeClass . ' ' . $colorClass . ' ' . $class);
    @endphp

    <span {{ $attributes->merge(['class' => "rounded-full text-sm font-medium $finalClasses"]) }}>
        {{ $slot }}
    </span>
