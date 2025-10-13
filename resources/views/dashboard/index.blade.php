<x-app-layout>
    {{-- ===== HEADER SLOT ===== --}}
    <x-slot name="header">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
                {{ __('Dashboard') }}
            </h1>
            <p class= "text-slate-500 dark:text-slate-400 mt-1">
                Welcome back, {{ Auth::user()->name }}! Let's get things done.
            </p>
        </div>
    </x-slot>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="max-w-7xl mx-auto mb-8">
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
        <div class="mb-10">
            <x-section-title>My Boards</x-section-title>

            @if ($boards->isEmpty())
                <x-section-paragraph>You don’t have any boards yet.</x-section-paragraph>
            @else
                <!-- Board Cards -->
                <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach ($boards as $board)
                        <li>
                            <a href="{{ route('dashboard.boards.show', $board) }}">
                                <div
                                    class="bg-card-light dark:bg-card-dark rounded-xl p-5 border-2 flex flex-col gap-4 shadow-sm hover:shadow-lg transition-shadow duration-300 min-h-[280px] border-pastel-pink dark:border-pink-900/50">
                                    <div class="flex items-start justify-between gap-4">
                                        <h3 class="text-lg font-bold text-slate-900 dark:text-white pr-4">
                                            {{ $board->name }}
                                        </h3>

                                        <span class="text-pink-500 dark:text-pink-400 mt-1 material-symbols-outlined">
                                            {{ $board->collaborators_count > 1 ? 'group' : 'person' }}

                                        </span>
                                    </div>
                                    <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-3">
                                        {{ $board->description }}
                                    </p>

                                    <div
                                        class="flex items-center justify-between pt-4 border-t border-slate-200 dark:border-slate-800 mt-auto">
                                        <div class="flex items-center gap-2">
                                            <img class="w-8 h-8 rounded-full"
                                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuA_zaJu3CUequj9yYD9CgvVtH3Q7W-85gh0QGgZ5Rp6lx4RZMdE_r4NGfIhvXJwvwCVxVp-AULmmIl4bylfDOXtF87luU88ml4ZMMM4wv7HL9ig0kFpK0YcHPSOSdZgdRUWfnf31wXL1Sun7tp2c1Fw9FzLQDTOl4QEUVdfAEwJDADeSdYiPkILz-ai0kfIEKqAMZU2M_9IGsVluTFFLTIPK_OUH7xII4IsodZLF0QmEC8H6OpXLEaqAGe7Hh_7Iw5LZJr0gq7X9zo">
                                            <div>
                                                <p class="text-xs text-slate-500 dark:text-slate-500">
                                                    @if ($board->collaborators_count > 1)
                                                        Shared by
                                                    @else
                                                        Owned by
                                                    @endif
                                                </p>
                                                <p class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                                    {{ $board->user->name }}
                                                </p>
                                            </div>
                                        </div>

                                        <form action="{{ route('dashboard.boards.manage.collaborators', $board) }}"
                                            method="GET">
                                            <x-action-button type="submit" icon="manage_accounts">
                                                Manage
                                            </x-action-button>
                                        </form>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <!-- Task Table -->
    @php
        $statusColors = [
            'open' => 'slate',
            'in_progress' => 'blue',
            'done' => 'green',
            'review' => 'purple',
        ];
        $priorityColors = [
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'red',
        ];

    @endphp
    <div class="max-w-7xl mx-auto mb-8">
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
                            <x-badge :color="$statusColors[$task->status] ?? 'slate'">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </x-badge>
                        </x-table.cell>
                        <x-table.cell>
                            <x-badge :color="$priorityColors[$task->priority] ?? 'slate'">
                                {{ ucfirst(str_replace('_', ' ', $task->priority)) }}
                            </x-badge>
                        </x-table.cell>
                        <x-table.cell>{{ $task->hard_deadline->format('M jS') }}</x-table.cell>
                    </x-table.row>
                @endforeach
            </tbody>
        </x-table>
        <div class="mt-4">
            {{ $tasks->links() }}
        </div>
    </div>

</x-app-layout>
