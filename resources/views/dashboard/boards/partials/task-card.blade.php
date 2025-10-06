@php
    $statusClasses = match($task->status) {
        'open' => 'bg-white dark:bg-card-dark/20 border-l-4 border-grey-100 dark:border-card-dark',
        'in_progress' => 'bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-300 dark:border-yellow-700', 
        'review' => 'bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-300 dark:border-blue-700', 
        'done' => 'bg-green-50 dark:bg-green-900/20 border-l-4 border-green-300 dark:border-green-700'
    };

    $isCloseToDeadline = now()->diffInDays($task->hard_deadline) <= 2;
    if ($isCloseToDeadline) {
        $statusClasses .= ' border-2 border-red-500/50 dark:border-red-400/50';
    }
@endphp
<a href="{{ route('dashboard.tasks.show', $task) }}" class="block">
    <div class="rounded-lg p-4 shadow-sm hover:shadow-lg transition-shadow cursor-grab {{ $statusClasses }}">
        <div class="flex items-start justify-between">
            <div>
                <p class="font-semibold text-slate-800 dark:text-slate-100">{{ $task->title }}</p>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $task->board->name }}</p>
            </div>
            @if ($isCloseToDeadline) 
                <span class="material-symbols-outlined text-red-500 dark:text-red-400 text-lg">warning</span> 
            @endif
        </div>
        <div class="flex items-center justify-between mt-3">
            @php
                $priorityClasses = match($task->priority) {
                    'low' => 'bg-green-100 dark:bg-green-700 text-green-800 dark:text-green-300',
                    'medium' => 'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300',
                    'high' => 'bg-red-100 dark:bg-red-700 text-red-800 dark:text-red-300',
                    default => 'bg-slate-100 dark:bg-slate-900/50 text-slate-800 dark:text-slate-100',
                };
            @endphp
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $priorityClasses }}">
                {{ ucfirst(str_replace('_', ' ', $task->priority)) }}
            </span>
            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $task->hard_deadline->format('M jS')}}</p>
        </div>    
    </div>  
</a>