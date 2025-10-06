@props([
    'value' => '',
    'checked' => false,
])

<div class="flex items-center space-x-4 p-3 rounded-lg bg-slate-100/70 dark:bg-slate-800/50 shadow-sm">
    <input
        type="checkbox"
        {{ $checked ? 'checked' : '' }}
        class="h-6 w-6 rounded-md border-slate-400 dark:border-slate-600
               text-primary focus:ring-primary/50
               bg-slate-200 dark:bg-slate-700 cursor-pointer flex-shrink-0"
    />

    <input
        type="text"
        value="{{ $value }}"
        name="subtasks[]"
        class="form-input !p-2 !bg-transparent !border-0 focus:!ring-2
               focus:!ring-primary/50 text-slate-700 dark:text-slate-300 flex-grow"
    />

    <button
        type="button"
        class="p-2 rounded-full hover:bg-slate-200 dark:hover:bg-slate-700
               text-slate-500 dark:text-slate-400"
    >
        <span class="material-symbols-outlined text-base">delete</span>
    </button>
</div>