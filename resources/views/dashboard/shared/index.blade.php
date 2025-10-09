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
        
    </x-slot>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="">
        <!-- Tabs + New Board Button -->
        <div class="border-b border-slate-200 dark:border-slate-800 mb-6">
            <div class="flex justify-between items-center">
                <nav class="flex gap-8">
                    <a href="{{ route('dashboard.index') }}" 
                       class="flex items-center justify-center border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary hover:border-primary/50 transition-colors pb-3">
                        <p class="text-sm font-bold">My Boards</p>
                    </a>

                    <a class="flex items-center justify-center border-b-2 border-primary text-primary pb-3">
                        <p class="text-sm font-bold">Shared Boards</p>
                    </a>

                    <a href="#" 
                       class="flex items-center justify-center border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary hover:border-primary/50 transition-colors pb-3">
                        <p class="text-sm font-bold">Timeline Overview</p>
                    </a>
                </nav>

                <div class="flex items-center gap-2">
                        <a href="{{ route('dashboard.boards.create') }}" class="flex items-center gap-2 text-sm font-medium text-role-viewer-light dark:text-role-viewer hover:text-neon-green dark:hover:text-neon-green transition-colors rounded-lg px-3 py-1.5 -my-1.5 -mx-3">
                            <span class="material-symbols-outlined text-role-viewer-light">add</span>
                            New Board
                        </a>
                </div>
            </div>
        </div>

        <!-- Search Boards -->
        <div class="relative mb-8">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500">
                search
            </span>
            <input
                type="text"
                placeholder="Search shared boards..."
                class="form-input w-full rounded-lg border-slate-200 dark:border-slate-800 bg-white dark:bg-border-dark/30 focus:ring-primary focus:border-primary pl-12 py-3 text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500"
            >
        </div>

        <!-- Shared Boards List -->
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-slate-900 mb-4 dark:text-white">Boards shared with me</h2>

            @if($sharedBoards->isEmpty())
                <p class="text-gray-500 dark:text-gray-400">
                    No boards have been shared with you yet.
                </p>
            @else
                <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($sharedBoards as $board)
                        @php
                            $isOwner = $board->user_id === Auth::id();
                            $role = $isOwner ? 'owner' : ($board->pivot->role ?? 'viewer');
                            $role = in_array($role, ['owner','editor','viewer']) ? $role : 'viewer';

                            $borderColorClass = [
                                'owner' => 'border-pastel-pink dark:border-pink-900/50', //redundant no owners in this view
                                'editor' => 'border-pastel-blue dark:border-blue-900/50 hover:border-blue-500/50',
                                'viewer' => 'border-pastel-green dark:border-green-900/50 hover:border-green-500/50',
                            ][$role];

                            $iconColorClass = [
                                'owner' => 'text-neon-pink',
                                'editor' => 'text-neon-blue',
                                'viewer' => 'text-neon-green',
                            ][$role];
                        @endphp

                        <li>
                            <a href="{{ route('dashboard.boards.show', $board) }}">
                                <div class="bg-card-light dark:bg-card-dark rounded-xl p-5 border-2 flex flex-col gap-4 shadow-sm hover:shadow-lg transition-shadow duration-300 min-h-[280px] {{ $borderColorClass }}">
                                    <div class="flex items-start justify-between">
                                        <h3 class="text-lg font-bold text-slate-900 dark:text-white pr-4">
                                            {{ $board->name }}
                                        </h3>
                                        <span class="material-symbols-outlined mt-1 {{ $iconColorClass }}">
                                            @if($isOwner)
                                                lock_open
                                            @else
                                                group
                                            @endif
                                        </span>
                                    </div>

                                    <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-3">
                                        {{ $board->description }}
                                    </p>

                                    <div class="flex items-center justify-between pt-4 border-t border-slate-200 dark:border-slate-800 mt-auto">
                                        <div class="flex items-center gap-2">
                                            <img 
                                                class="w-8 h-8 rounded-full"
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
    </div>
</x-app-layout>
