@props([
    'color' => 'slate',
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

@php
    $colorClass = trim($colorClass . ' ' . $class);
@endphp

<span {{ $attributes->merge(['class' => "px-3 py-1 rounded-full text-sm font-medium $colorClass"]) }}>
    {{ $slot }}
</span>

{{-- // $statusColors = [
    //     'open' => 'bg-teal-900 dark:bg-teal-300/50 text-teal-100 dark:text-teal-200',
    //     'in_progress' => 'bg-blue-900 dark:bg-blue-500/50 text-blue-100 dark:text-blue-200',
    //     'done' => 'bg-green-100 dark:bg-green-700 text-green-800 dark:text-green-300',
    //     'review' => 'bg-purple-900 dark:bg-purple-300/50 text-purple-100 dark:text-purple-900',
    // ];

    // $priorityColors = [
    //     'low' => 'bg-green-100 dark:bg-green-700 text-green-800 dark:text-green-300',
    //     'medium' => 'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300',
    //     'high' => 'bg-red-100 dark:bg-red-600/70 text-red-800 dark:text-red-400',
    // ];

    // $colorClass = $class;

    // if ($status && isset($statusColors[$status])) {
    //     $colorClass = $statusColors[$status];
    // } elseif ($priority && isset($priorityColors[$priority])) {
    //     $colorClass = $priorityColors[$priority];
    // } --}}



{{-- <span {{ $attributes->merge(['class' => "px-3 py-1 rounded-full text-sm font-medium $colorClass"]) }}>
    {{ $slot }}
</span> --}}
