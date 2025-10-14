<x-app-layout>
    {{-- ===== HEADER SLOT ===== --}}
    <x-slot name="header">
        <x-section class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
                Shared Boards
            </h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">
                Welcome back, {{ Auth::user()->name }}! Let's get things done.
            </p>
        </x-section>
    </x-slot>

    {{-- ===== MAIN CONTENT ===== --}}
    <x-container class="max-w-7xl mx-auto mb-8">
        <!-- Tabs -->
        <x-tab-bar>
            <x-tab-bar.link label="My Boards" href="{{ route('dashboard.index') }}" />
            <x-tab-bar.link active label="Shared Boards" />
            <x-tab-bar.link label="Timeline Overview" />
        </x-tab-bar>

        <!-- Search Boards -->
        <x-search-input placeholder="Search shared boards..." class="mb-8" />

        <!-- Shared Boards List -->
        <x-section>
            <x-section-title>Boards shared with me</x-section-title>

            @if ($sharedBoards->isEmpty())
                <x-section-paragraph>No boards have been shared with you yet.</x-section-paragraph>
            @else
                <!-- Board Cards -->
                <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach ($sharedBoards as $board)
                        <li>
                            <x-board-card :board="$board" show-leave="true" />
                        </li>
                    @endforeach
                </ul>
            @endif
        </x-section>
    </x-container>
</x-app-layout>
