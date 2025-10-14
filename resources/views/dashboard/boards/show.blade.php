<x-app-layout>
    <div class="flex h-screen flex-col">

        {{-- ===== MAIN CONTENT ===== --}}
        <main class="flex-1 overflow-y-auto p-6 lg:p-10">
            <x-container class="max-w-7xl mx-auto">
                <!-- Board Title + Description -->
                <x-section class="mb-8">
                    <h1 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $board->name }}</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-1">{{ $board->description }}</p>
                    {{-- bugfix:change to exclude user himself.  --}}
                    @if ($board->collaborators->isNotEmpty())
                        <p class="text-sm tet-slate-600 dark:text-slate-300 mt-2">
                            Team:
                            <span class="font-medium text-slate-800 dark:text-slate-100">
                                {{ $board->collaborators->pluck('name')->implode(', ') }}
                            </span>
                        </p>
                    @endif
                </x-section>
                <x-section class="mb-8">
                    <form action="{{ route('dashboard.boards.manage.collaborators', $board) }}" method="GET">
                        <x-action-button type="submit" icon="manage_accounts">
                            Manage
                        </x-action-button>
                    </form>
                </x-section>

                <x-tab-bar>
                    <x-tab-bar.link active label="Kanban" />
                    <x-tab-bar.link label="Timeline" />
                    <x-slot name="actions">
                        <form action="{{ route('dashboard.boards.edit', $board) }}" method="GET">
                            <x-action-button type="submit" icon="edit">
                                Edit Board
                            </x-action-button>
                        </form>
                        <form action="{{ route('dashboard.boards.tasks.create', $board) }}" method="GET">
                            <x-action-button type="submit" icon="add">
                                New Task
                            </x-action-button>
                        </form>
                    </x-slot>
                </x-tab-bar>

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
                                    @include('dashboard.boards.partials.task-card', ['task' => $task])
                                @empty
                                    <p class="text-slate-500 dark:text-slate-400">No tasks yet.</p>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-container>
        </main>


    </div>
</x-app-layout>
