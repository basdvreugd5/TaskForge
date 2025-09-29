<x-app-layout>
    
    <x-slot name="header">
        <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
            {{ $board->name }}
        </h1>
        <p class= "text-slate-500 dark:text-slate-400 mt-1">
            {{ $board->description }}
        </p>
    </x-slot>

    <div class="border-b border-slate-200 dark:border-slate-800 mb-6">
        <div class="flex justify-between items-center">
            <nav class="flex gap-8">
                <a class="flex items-center justify-center border-b-2 border-primary text-primary pb-3">
                    <p class="text-sm font-bold">Kanban</p>
                </a>
                <a class="flex items-center justify-center border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary hover:border-primary/50 transition-colors pb-3">
                    <p class="text-sm font-bold">Timeline</p>
                </a>
            </nav>
        
        <div class="flex items-center gap-2">
        <button class="flex items-center gap-2 rounded-lg px-2 text-sm font-medium bg-primary text-white hover:bg-primary/90 transition-colors">
            <span class="material-symbols-outlined text-base">add</span>
            New Task                
        </button>
        </div>
    </div>
    </div>
    @php
        $statuses = [
            'open' =>'To Do',
            'in_progress' => 'In Progress',
            'review' => 'Review',
            'done' => 'Done',
];
    @endphp

    <div class="grid grid-cols-1 @container xl:grid-cols-4 gap-6">
        @foreach ($statuses as $statusKey => $statusLabel)
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">{{ $statusLabel }}</h2>
                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">
                    {{ $board->tasks->where('status', $statusKey)->count() }}
                </span>
            </div>
            <div class="flex flex-col gap-4">
                @forelse ($board->tasks->where('status', $statusKey) as $task)
                @include('boards.partials.task-card', ['task' => $task])
                @empty
                <p class= "text-slate-500 dark:text-slate-400">No tasks yet.</p>
                @endforelse
            </div>
        </div>
    @endforeach
    </div>

</x-app-layout>