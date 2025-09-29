<div class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-4 shadow-sm hover:shadow-lg transition-shadow cursor-grab">
    <p class="font-semibold text-slate-800 dark:text-slate-100">{{ $task->title }}</p>
     <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $board->name }}</p>
     <div class="flex items-center justify-between mt-3">
        @php
            $priorityClasses = match($task->priority) {
                'low' => 'bg-green-100 dark:bg-green-700 text-green-800 dark-text-green-300',
                'medium' => 'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300',
                'high' => 'bg-red-100 dark:bg-red-700 text-red-800 dark-text-red-300',
                default => 'bg-slate-100 dark:bg-slate-900/50 text-slate-800 dark:text-slate-300',
            }
        @endphp
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $priorityClasses }} ">
            {{ ucfirst(str_replace('_', ' ', $task->priority)) }}
        </span>
        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $task->hard_deadline->format('M jS')}}</p>
    </div>
</div>