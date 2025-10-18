@props(['type' => 'info', 'message'])

@php
    $styles = [
        'success' =>
            'bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300',
        'error' =>
            'bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300',
        'info' =>
            'bg-blue-100 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 text-blue-700 dark:text-blue-300',
        'warning' =>
            'bg-yellow-100 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-700 text-yellow-700 dark:text-yellow-300',
    ];
@endphp

@if ($message)
    <div
        {{ $attributes->merge([
            'class' => 'p-4 mx-6 mt-4 rounded-lg font-medium ' . ($styles[$type] ?? $styles['info']),
            'role' => 'alert',
        ]) }}>
        {{ $message }}
    </div>
@endif
