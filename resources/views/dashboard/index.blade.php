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
        <div class="border-b border-slate-200 dark:border-slate-800 mb-6">
            <div class="flex justify-between items-center">
                <nav class="flex gap-8">
                    <a class="flex items-center justify-center border-b-2 border-primary text-primary pb-3">
                        <p class="text-sm font-bold">My Boards</p>
                    </a>
                    <a href="{{ route('dashboard.shared') }}"
                        class="flex items-center justify-center border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary hover:border-primary/50 transition-colors pb-3">
                        <p class="text-sm font-bold">Shared Boards</p>
                    </a>
                    <a
                        class="flex items-center justify-center border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary hover:border-primary/50 transition-colors pb-3">
                        <p class="text-sm font-bold">Timeline Overview</p>
                    </a>
                </nav>
                <div class="flex items-center gap-2">
                    <a href="{{ route('dashboard.boards.create') }}"
                        class="flex items-center gap-2 text-sm font-medium text-role-viewer-light dark:text-role-viewer hover:text-neon-green dark:hover:text-neon-green transition-colors rounded-lg px-3 py-1.5 -my-1.5 -mx-3">
                        <span class="material-symbols-outlined text-role-viewer-light">add</span>
                        New Board
                    </a>
                </div>
            </div>
        </div>

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
                                            <button type="submit"
                                                class="flex items-center gap-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary transition-colors rounded-lg px-3 py-1.5 -my-1.5 -mx-3 hover:bg-slate-100 dark:hover:bg-slate-800">
                                                <span class="material-symbols-outlined text-base">
                                                    manage_accounts
                                                </span>
                                                Manage
                                            </button>
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
    <div class="max-w-7xl mx-auto mb-8">
        <x-section-title>Today's Focus</x-section-title>
        <x-table>
            <thead
                class="bg-slate-50 dark:bg-card-dark/80 text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 font-medium" scope="col">Task</th>
                    <th class="px-6 py-4 font-medium" scope="col">Board</th>
                    <th class="px-6 py-4 font-medium" scope="col">Status</th>
                    <th class="px-6 py-4 font-medium" scope="col">Priority</th>
                    <th class="px-6 py-4 font-medium" scope="col">Due Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-800/60">
                @forelse($tasks as $task)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-900 dark:text-white">
                            {{ $task->title }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-900 dark:text-white">
                            {{ $task->board->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'open' => 'slate',
                                    'in_progress' => 'blue',
                                    'done' => 'green',
                                    'review' => 'purple',
                                ];
                            @endphp
                            <x-badge :color="$statusColors[$task->status] ?? 'slate'">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </x-badge>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $priorityColors = [
                                    'low' => 'green',
                                    'medium' => 'yellow',
                                    'high' => 'red',
                                ];
                            @endphp
                            <x-badge :color="$priorityColors[$task->priority] ?? 'slate'">
                                {{ ucfirst(str_replace('_', ' ', $task->priority)) }}
                            </x-badge>
                        </td>
                        <td class="px-6 py-4 text-center text-slate-900 dark:text-white">
                            {{ $task->hard_deadline->format('M jS') }}
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </x-table>
        <div class="mt-4">
            {{ $tasks->links() }}
        </div>
    </div>

</x-app-layout>
