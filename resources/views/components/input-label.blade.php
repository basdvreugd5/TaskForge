@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-xl font-semibold text-slate-800 dark:text-slate-200 mb-2']) }}>
    {{ $value ?? $slot }}
</label>
