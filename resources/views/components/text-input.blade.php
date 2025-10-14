@props(['disabled' => false, 'type' => 'text'])

@if ($type === 'textarea')
    <textarea @disabled($disabled)
        {{ $attributes->merge(['class' => 'form-textarea w-full pr-4 py-2.5 rounded-lg bg-background-light dark:bg-background-dark border border-slate-300 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-primary transition']) }}>{{ $slot ?? '' }}</textarea>
@else
    <input type ="{{ $type }}" @disabled($disabled)
        {{ $attributes->merge(['class' => 'form-input w-full pr-4 py-2.5 rounded-lg bg-background-light dark:bg-background-dark border border-slate-300 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-primary transition']) }}>
@endif
