@props(['disabled' => false, 'type' => 'text'])

@if ($type === 'textarea')
    <textarea @disabled($disabled) {{ $attributes->merge(['class' => 'form-textarea w-full w-full px-4 py-3 bg-slate-100 dark:bg-border-dark/30 border border-slate-200 dark:border-slate-700 rounded-lg text-lg text-slate-800 dark:text-slate-200 focus:ring-primary focus:border-primary transition-shadow']) }}>{{  $slot ?? '' }}</textarea>
    
@else

<input type ="{{ $type }}" @disabled($disabled) {{ $attributes->merge(['class' => 'form-input w-full w-full px-4 py-3 bg-slate-100 dark:bg-border-dark/30 border border-slate-200 dark:border-slate-700 rounded-lg text-lg text-slate-800 dark:text-slate-200 focus:ring-primary focus:border-primary transition-shadow']) }}>

@endif