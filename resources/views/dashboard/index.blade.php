<x-app-layout>
    {{-- ===== HEADER SLOT ===== --}}
    <x-slot name="header">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
                Dashboard
            </h1>
            <p class= "text-slate-500 dark:text-slate-400 mt-1">
                Welcome back, {{ Auth::user()->name }}! Let's get things done.
            </p>
        </div>
    </x-slot>

    {{-- ===== MAIN CONTENT ===== --}}
    <x-container class="max-w-7xl mx-auto mb-8">

        <!-- Tabs + New Task Button -->
        <x-tab-bar>
            <x-tab-bar.link active label="My Boards" />
            <x-tab-bar.link label="Shared Boards" href="{{ route('dashboard.shared') }}" />
            <x-tab-bar.link label="Timeline Overview" />
            <x-slot name="actions">
                <form action="{{ route('dashboard.boards.create') }}" method="GET">
                    <x-action-button type="submit" icon="add">
                        New Board
                    </x-action-button>
                </form>
            </x-slot>
        </x-tab-bar>

        <!-- Search Tasks -->
        <x-search-input placeholder="Search boards..." class="mb-8" />

        <!-- Boards List -->
        <x-section>
            <x-section-title>My Boards</x-section-title>

            @if ($boards->isEmpty())
                <x-section-paragraph>You don’t have any boards yet.</x-section-paragraph>
            @else
                <!-- Board Cards -->
                <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach ($boards as $board)
                        <li>
                            <x-board-card :board="$board" show-manage="true" />
                        </li>
                    @endforeach
                </ul>
            @endif
        </x-section>
    </x-container>

    <!-- Task Table -->
    @php
        $statusColorMap = [
            'open' => 'blue',
            'in_progress' => 'yellow',
            'review' => 'purple',
            'done' => 'green',
        ];
        $priorityColorMap = [
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'red',
        ];
    @endphp

    <x-container class="max-w-7xl mx-auto mb-8">
        <x-section-title>Today's Focus</x-section-title>
        <x-table>
            <x-table.head>
                <x-table.row>
                    <x-table.header-cell>Task</x-table.header-cell>
                    <x-table.header-cell>Board</x-table.header-cell>
                    <x-table.header-cell>Status</x-table.header-cell>
                    <x-table.header-cell>Priority</x-table.header-cell>
                    <x-table.header-cell>Due Date</x-table.header-cell>
                </x-table.row>
            </x-table.head>

            <tbody class="divide-y divide-slate-200 dark:divide-slate-800/60">
                @foreach ($tasks as $task)
                    <x-table.row>
                        <x-table.cell>{{ $task->title }}</x-table.cell>
                        <x-table.cell>{{ $task->board->name }}</x-table.cell>
                        <x-table.cell>
                            <x-badge color="{{ $statusColorMap[$task->status] ?? 'slate' }}">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </x-badge>
                        </x-table.cell>
                        <x-table.cell>
                            <x-badge color="{{ $priorityColorMap[$task->priority] ?? 'slate' }}">
                                {{ ucfirst($task->priority) }}
                            </x-badge>
                        </x-table.cell>
                        <x-table.cell>{{ \Carbon\Carbon::parse($task->hard_deadline)->format('d F H:i') }}</x-table.cell>
                    </x-table.row>
                @endforeach
            </tbody>
        </x-table>
        <div class="mt-4">
            {{ $tasks->links() }}
        </div>
    </x-container>
</x-app-layout>
