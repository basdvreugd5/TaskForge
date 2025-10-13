<div class="border-b border-slate-200 dark:border-slate-800 mb-6">
    <div class="flex justify-between items-center">
        <nav class="flex gap-8">
            {{ $slot }}
        </nav>

        @isset($actions)
            <div class="flex items-center gap-2">
                {{ $actions }}
            </div>
        @endisset
    </div>
</div>
