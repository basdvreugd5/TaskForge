@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'form-input w-full rounded-lg border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:ring-primary focus:border-primary py-3 text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500']) }}>
