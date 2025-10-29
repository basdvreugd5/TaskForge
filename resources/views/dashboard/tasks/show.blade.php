<x-app-layout>
    <x-container class="max-w-4xl mx-auto p-6 lg:p-10">
        <!-- Back to Boards Button & Edit Task Button -->
        <div class="flex items-center justify-between mb-8">
            <form action="{{ route('dashboard.boards.show', $task->board) }}" method="GET">
                <x-action-button type="submit" icon="arrow_back">
                    Back to Board
                </x-action-button>
            </form>
            <form action="{{ route('dashboard.tasks.edit', $task) }}" method="GET">
                <x-action-button type="submit" icon="edit">
                    Edit Task
                </x-action-button>
            </form>
        </div>
        <!-- Task Card -->
        <x-card class="" variant=form>
            <!-- Title + Board -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <h1 class="text-4xl font-bold text-slate-900 dark:text-white">
                    {{ $task->title }}
                </h1>
                <div class="flex flex-col gap-4 flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-amber-500">
                            @switch($task->status)
                                @case('open')
                                    task_alt
                                @break

                                @case('in_progress')
                                    hourglass_top
                                @break

                                @case('review')
                                    rate_review
                                @break

                                @case('done')
                                    check_circle
                                @break

                                @default
                                    help_outline
                            @endswitch
                        </span>
                        <span class="text-lg font-medium text-slate-600 dark:text-slate-300">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-red-500">
                            @switch($task->priority)
                                @case('low')
                                    arrow_downward_alt
                                @break

                                @case('medium')
                                    drag_handle
                                @break

                                @case('high')
                                    priority_high
                                @break

                                @default
                                    flag
                            @endswitch
                        </span>
                        <span class="text-lg font-medium text-slate-600 dark:text-slate-300">
                            {{ ucfirst(str_replace('_', ' ', $task->priority)) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-200 mb-2">
                        Project
                    </h2>

                    <x-badge color="{{ 'blue' }}">
                        {{ ucfirst($task->board->name) }}
                    </x-badge>
                </div>
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-200 mb-2 mt-4">
                        Author
                    </h2>
                    <x-badge color="{{ 'teal' }}">
                        {{ ucfirst($task->board->user->name) }}
                    </x-badge>
                </div>
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
                        <div
                            class="flex items-center gap-3 rounded-lg bg-orange-100/50 dark:bg-orange-900/30 p-3 border-l-4 border-orange-500/60 dark:border-orange-400/60">
                            <span class="material-symbols-outlined text-orange-600 dark:text-orange-400 text-xl">
                                error_outline
                            </span>
                            <div>
                                <p class="font-semibold text-orange-800 dark:text-orange-200">
                                    {{ \Carbon\Carbon::parse($task->hard_deadline)->format('M d, Y H:i') }}
                                </p>
                                <p class="text-sm text-orange-700 dark:text-orange-300">
                                    Hard Deadline
                                </p>
                            </div>
                        </div>
                        <!-- Soft Due Date -->
                        <div
                            class="flex items-center gap-3 rounded-lg bg-blue-100/50 dark:bg-blue-900/30 p-3 border-l-4 border-blue-400/50 dark:border-blue-600/50">
                            <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-xl">
                                event_available
                            </span>
                            <div>
                                <p class="font-semibold text-blue-800 dark:text-blue-200">
                                    {{ \Carbon\Carbon::parse($task->soft_due_date)->format('M d, Y H:i') }}
                                </p>
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    Soft Due Date
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tags -->
                {{-- <div>
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">
                        Tags
                    </h3>
                    <div class="flex flex-wrap gap-3 items-center">
                        @forelse($task->tags ?? [] as $tag)
                            <x-badge color="green" size="lg">
                                {{ $tag->name }}
                            </x-badge>
                        @empty
                            <p class="text-slate-500 dark:text-slate-400 text-sm">No tags</p>
                        @endforelse
                        <!-- Add Tag Button -->
                        <button
                            class="flex items-center justify-center size-9 rounded-full bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors">
                            <span class="material-symbols-outlined text-slate-600 dark:text-slate-300 text-xl">
                                add
                            </span>
                        </button>
                    </div>
                </div>
            </div> --}}
                <!-- Tags -->
                <div x-data="{ open: false }">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Tags</h3>

                    <div class="flex flex-wrap gap-3 items-center">
                        @forelse($task->tags as $tag)
                            <div class="relative group inline-flex items-center">
                                <x-badge color="green" size="lg">
                                    {{ $tag->name }}
                                </x-badge>

                                <form method="POST"
                                    action="{{ route('dashboard.tasks.tags.destroy', [$task, $tag]) }}"
                                    class="absolute  left-1 hidden group-hover:block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="backdrop-blur-sm rounded-full p-0.5 px-4  shadow hover:bg-red-500/40 hover:text-white transition-all">
                                        <span class="material-symbols-outlined text-xs">
                                            delete
                                        </span>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="text-slate-500 dark:text-slate-400 text-xs">No tags</p>
                        @endforelse

                        <!-- Add Tag Button -->
                        <button @click="open = !open"
                            class="flex items-center justify-center size-9 rounded-full bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors">
                            <span class="material-symbols-outlined text-slate-600 dark:text-slate-300 text-xl">
                                add
                            </span>
                        </button>
                    </div>

                    <!-- Add Tag Form -->
                    <form x-show="open" x-cloak method="POST"
                        action="{{ route('dashboard.tasks.tags.store', $task) }}" class="mt-3 flex gap-2">
                        @csrf
                        <input type="text" name="name" placeholder="New tag name"
                            class="border rounded px-2 py-1 text-sm w-40 dark:bg-slate-700 dark:text-white">
                        <button type="submit"
                            class="bg-green-500 text-white text-sm px-3 py-1 rounded hover:bg-green-600">
                            Add
                        </button>
                    </form>
                </div>
                <!-- Subtasks -->
                <div>
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">
                            Subtasks
                        </h2>
                        <p class="subtask-progress text-base text-slate-500 dark:text-slate-400 font-medium">
                            {{ collect($task->checklist)->where('is_completed', true)->count() }}
                            of
                            {{ count($task->checklist ?? []) }} completed
                        </p>
                    </div>
                    <div class="space-y-4">
                        @foreach ($task->checklist ?? [] as $i => $item)
                            <label
                                class="flex items-center space-x-4 p-4 rounded-lg bg-slate-100/70 dark:bg-border-dark/30 hover:bg-slate-200/70 dark:hover:bg-border-dark/50 transition-colors cursor-pointer shadow-sm">
                                <input type="checkbox" @checked($item['is_completed']) data-index="{{ $i }}"
                                    class="subtask-checkbox h-6 w-6 rounded-md border-slate-400 dark:border-border-dark text-primary focus:ring-primary/50 bg-slate-200 dark:bg-slate-700">
                                <span
                                    class="text-lg text-slate-600 dark:text-slate-400 {{ $item['is_completed'] ? 'line-through' : '' }}">
                                    {{ $item['title'] }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
        </x-card>
    </x-container>

    <script>
        document.querySelectorAll('.subtask-checkbox').forEach(cb => {
            cb.addEventListener('change', async e => {
                let index = e.target.dataset.index;
                let taskId = "{{ $task->id }}";

                const response = await fetch(`/dashboard/tasks/${taskId}/checklist`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        index: index,
                        is_completed: e.target.checked ? true : false
                    })
                });

                if (response.ok) {
                    // Toggle line-through immediately
                    let label = e.target.closest('label').querySelector('span');
                    if (e.target.checked) {
                        label.classList.add('line-through');
                    } else {
                        label.classList.remove('line-through');
                    }

                    // Update "X of Y completed"
                    let data = await response.json();
                    let completed = data.checklist.filter(i => i.is_completed).length;
                    let total = data.checklist.length;
                    document.querySelector('.subtask-progress').textContent =
                        `${completed} of ${total} completed`;
                }
            });
        });
    </script>
</x-app-layout>
