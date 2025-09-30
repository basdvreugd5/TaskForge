<x-app-layout>
    <div class="flex h-screen flex-col">

        <!-- Main -->
        <main class="flex-1 p-6 lg:p-10">
            <div class="max-w-4xl mx-auto">

                <!-- Back to Boards Button & Edit Task Button -->
                <div class="flex items-center justify-between mb-8">
                    <a href="{{ route('boards.show', $task->board) }}" 
                       class="flex items-center gap-2 text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">arrow_back</span>
                        <span class="text-sm font-medium">Back to Board</span>
                    </a>
                    <a href="{{ route('tasks.edit', $task) }}" class="flex items-center gap-2 px-5 py-3 rounded-lg bg-primary text-white font-medium shadow-lg shadow-primary/30 hover:bg-primary/90 transition-all duration-300">
                        <span class="material-symbols-outlined">
                            edit
                        </span>
                         Edit Task 
                    </a>
                </div>
@php
    $statusIcons = match($task->status) {
        'open' => 'task_alt',
        'in_progress' => 'hourglass_top', 
        'review' => 'rate_review', 
        'done' => 'check_circle'
    };


@endphp
                <!-- Task Card -->
                <div class="bg-white dark:bg-card-dark rounded-xl shadow-lg p-8 md:p-12 space-y-12">

                    <!-- Title + Board -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <h1 class="text-4xl font-bold text-slate-900 dark:text-white">
                            {{ $task->title }}
                        </h1>
                        <div class="flex flex-col gap-4 flex-shrink-0">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-amber-500">
                                    {{ $statusIcons }}
                                </span>
                                <span class="text-lg font-medium text-slate-600 dark:text-slate-300">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </div>
                            @php
                                $priorityIcons = match($task->priority) {
                                    'low' => 'arrow_downward_alt',
                                    'medium' => 'drag_handle',
                                    'high' => 'priority_high',
                                    default => 'flag',
                                };
                            @endphp
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-red-500">
                                    {{ $priorityIcons }}
                                </span>
                                <span class="text-lg font-medium text-slate-600 dark:text-slate-300">
                                    {{ ucfirst(str_replace('_', ' ', $task->priority)) }}
                            </div>                           
                        </div>
                    </div>
                    <div class="mt-8">
                        <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-200 mb-2">
                            Project
                        </h2>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-teal-100 dark:bg-teal-900/50 text-teal-800 dark:text-teal-300">
                            {{ $task->board->name }}
                        </span>
                        
                    </div>

                    <!-- Description -->
                    <div class="mt-8">
                        <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-200 mb-2">Description</h2>
                        <p class="text-slate-600 dark:text-slate-400 text-lg leading-relaxed">
                            {{ $task->description }}
                        </p>
                    </div>

                    <!-- Due Dates + Tags -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <!-- Due Dates -->
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">
                                Due Dates
                            </h3>
                            <div class="space-y-3">
                                <!-- Hard Deadline -->
                                <div class="flex items-center gap-3 rounded-lg bg-orange-100/50 dark:bg-orange-900/30 p-3 border-l-4 border-orange-500/60 dark:border-orange-400/60">
                                    <span class="material-symbols-outlined text-orange-600 dark:text-orange-400 text-xl">
                                        error_outline
                                    </span>
                                    <div>
                                        <p class="font-semibold text-orange-800 dark:text-orange-200">
                                            {{ $task->hard_deadline }}
                                        </p>
                                        <p class="text-sm text-orange-700 dark:text-orange-300">
                                            Hard Deadline
                                        </p>
                                    </div>
                                </div>
                                <!-- Soft Due Date -->
                                <div class="flex items-center gap-3 rounded-lg bg-blue-100/50 dark:bg-blue-900/30 p-3 border-l-4 border-blue-400/50 dark:border-blue-600/50">
                                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-xl">
                                        event_available
                                    </span>
                                    <div>
                                        <p class="font-semibold text-blue-800 dark:text-blue-200">
                                            {{ $task->soft_due_date }}
                                        </p>
                                        <p class="text-sm text-blue-700 dark:text-blue-300">
                                            Soft Due Date
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tags -->
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">
                                Tags
                            </h3>
                            <div class="flex flex-wrap gap-3 items-center">
                                @forelse($task->tags ?? [] as $tag)
                                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-base font-medium bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300">
                                        {{ $tag->name }}
                                    </span>
                                @empty
                                    <p class="text-slate-500 dark:text-slate-400 text-sm">No tags</p>
                                @endforelse

                                <!-- Add Tag Button -->
                                <button class="flex items-center justify-center size-9 rounded-full bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors">
                                    <span class="material-symbols-outlined text-slate-600 dark:text-slate-300 text-xl">
                                        add
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Subtasks -->
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">
                                Subtasks
                            </h2>
                            <p class="text-base text-slate-500 dark:text-slate-400 font-medium">
                                {{-- Example: count completed subtasks --}}
                                {{ collect($task->checklist)->where('is_completed', true)->count() }}
                                of
                                {{ count($task->checklist ?? []) }} completed
                            </p>
                        </div>

                        <div class="space-y-4">
                            @foreach($task->checklist ?? [] as $item)
                                <label class="flex items-center space-x-4 p-4 rounded-lg bg-slate-100/70 dark:bg-border-dark/30 hover:bg-slate-200/70 dark:hover:bg-border-dark/50 transition-colors cursor-pointer shadow-sm">
                                    <input type="checkbox"
                                           @checked($item['is_completed'])
                                           class="h-6 w-6 rounded-md border-slate-400 dark:border-border-dark text-primary focus:ring-primary/50 bg-slate-200 dark:bg-slate-700">
                                    <span class="text-lg text-slate-600 dark:text-slate-400 {{ $item['is_completed'] ? 'line-through' : '' }}">
                                        {{ $item['title'] }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
</x-app-layout>