        <div class="relative flex items-center {{ $class ?? '' }}">
            <span
                class="material-symbols-outlined absolute left-4 -translate-y-52%] text-slate-400 dark:text-slate-500 pointer-events-none">
                search
            </span>
            <input
                {{ $attributes->merge([
                    'class' =>
                        'form-input w-full rounded-lg border-slate-200 dark:border-slate-800 bg-white dark:bg-border-dark/30 focus:ring-primary focus:border-primary pl-12 py-3 text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500',
                    'placeholder' => $placeholder ?? 'Search...',
                    'type' => 'text',
                ]) }}>
        </div>
