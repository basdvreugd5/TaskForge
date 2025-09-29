@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2']) }}>
    {{ $value ?? $slot }}
</label>
