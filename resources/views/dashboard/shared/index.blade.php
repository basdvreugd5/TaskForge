<x-app-layout>
    {{-- ===== HEADER SLOT ===== --}}
    <x-slot name="header">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
                Shared Boards
            </h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">
                Welcome back, {{ Auth::user()->name }}! Let's get things done.
            </p>
        </div>
    </x-slot>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="max-w-7xl mx-auto mb-8">
        <!-- Tabs -->
        <x-tab-bar>
            <x-tab-bar.link label="My Boards" href="{{ route('dashboard.index') }}" />
            <x-tab-bar.link active label="Shared Boards" />
            <x-tab-bar.link label="Timeline Overview" />
        </x-tab-bar>

        <!-- Search Boards -->
        <x-search-input placeholder="Search shared boards..." class="mb-8" />

        <!-- Shared Boards List -->
        <div class="mb-10">
            <x-section-title>Boards shared with me</x-section-title>

            @if ($sharedBoards->isEmpty())
                <x-section-paragraph>No boards have been shared with you yet.</x-section-paragraph>
            @else
                <!-- Board Cards -->
                <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach ($sharedBoards as $board)
                        @php
                            $isOwner = $board->user_id === Auth::id();
                            $role = $isOwner ? 'owner' : $board->pivot->role ?? 'viewer';
                            $role = in_array($role, ['owner', 'editor', 'viewer']) ? $role : 'viewer';
                        @endphp
                        <li>
                            <a href="{{ route('dashboard.boards.show', $board) }}">
                                <div @class([
                                    'bg-card-light dark:bg-card-dark rounded-xl p-5 border-2 flex flex-col gap-4 shadow-sm hover:shadow-lg transition-shadow duration-300 min-h-[280px]',
                                    'border-pastel-pink dark:border-pink-900/50' => $role === 'owner',
                                    'border-pastel-blue dark:border-blue-900/50 hover:border-blue-500/50' =>
                                        $role === 'editor',
                                    'border-pastel-green dark:border-green-900/50 hover:border-green-500/50' =>
                                        $role === 'viewer',
                                ])>
                                    <div class="flex items-start justify-between">
                                        <h3 class="text-lg font-bold text-slate-900 dark:text-white pr-4">
                                            {{ $board->name }}
                                        </h3>
                                        <span @class([
                                            'material-symbols-outlined mt-1',
                                            'text-neon-pink' => $role === 'owner',
                                            'text-neon-blue' => $role === 'editor',
                                            'text-neon-green' => $role === 'viewer',
                                        ])>
                                            @if ($isOwner)
                                                lock_open
                                            @else
                                                group
                                            @endif
                                        </span>
                                    </div>

                                    <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-3">
                                        {{ $board->description }}
                                    </p>

                                    <div
                                        class="flex items-center justify-between pt-4 border-t border-slate-200 dark:border-slate-800 mt-auto">
                                        <div class="flex items-center gap-2">
                                            <img class="w-8 h-8 rounded-full"
                                                src="https://placehold.co/40x40/5d5f66/ffffff?text={{ strtoupper(substr($board->user->name, 0, 1)) }}"
                                                alt="{{ $board->user->name }}">
                                            <div>
                                                <p class="text-xs text-slate-500 dark:text-slate-500">
                                                    Owned by
                                                </p>
                                                <p class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                                    {{ $board->user->name }}
                                                </p>
                                            </div>
                                        </div>

                                        <form action="{{ route('dashboard.boards.leave', $board) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to leave the board: {{ $board->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="flex items-center gap-2 text-sm font-medium text-red-500 dark:text-red-400 hover:text-red-600 dark:hover:text-red-500 transition-colors rounded-lg px-3 py-1.5 -my-1.5 -mx-3 hover:bg-red-50 dark:hover:bg-slate-800/50">
                                                <span class="material-symbols-outlined text-base">
                                                    logout
                                                </span>
                                                Leave
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
</x-app-layout>
