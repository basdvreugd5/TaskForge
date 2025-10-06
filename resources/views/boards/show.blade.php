<x-app-layout>
    <div class="flex h-screen flex-col">

        <!-- Main -->
        <main class="flex-1 overflow-y-auto p-6 lg:p-10">
            <div class="max-w-7xl mx-auto">
                <!-- Board Title + Description -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $board->name }}</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-1">{{ $board->description }}</p>

                    @if ($board->collaborators->isNotEmpty())
                        <p class="text-sm tet-slate-600 dark:text-slate-300 mt-2">
                            Team:
                            <span class="font-medium text-slate-800 dark:text-slate-100">
                                {{ $board->collaborators->pluck('name')->implode(', ') }}
                            </span>
                        </p>
                    @endif

                </div>

                <!-- Tabs + New Task Button -->
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
                            <a href="{{ route('boards.edit', $board) }}" class="flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium bg-primary text-white hover:bg-primary/90 transition-colors">
                                <span class="material-symbols-outlined text-base">edit</span>
                                Edit Board
                            </a>
                            <a href="{{ route('boards.tasks.create', $board) }}" class="flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium bg-primary text-white hover:bg-primary/90 transition-colors">
                                <span class="material-symbols-outlined text-base">add</span>
                                New Task
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Kanban Grid -->
                <div class="grid grid-cols-1 @container xl:grid-cols-4 gap-6">
                    @php
                        $statuses = [
                            'open' => 'To Do',
                            'in_progress' => 'In Progress',
                            'review' => 'Review',
                            'done' => 'Done',
                        ];
                    @endphp

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
                                    <p class="text-slate-500 dark:text-slate-400">No tasks yet.</p>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>

        
    </div>
</x-app-layout>
