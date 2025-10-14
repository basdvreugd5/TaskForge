<x-app-layout>
    <div class="flex h-screen flex-col">

        <!-- Main -->
        <main class="flex-1 p-6 lg:p-10">
            <x-container class="max-w-4xl mx-auto">
                <!-- Back to Boards Button & Delete Board Button -->
                <x-section class="flex items-center justify-between mb-8">
                    <form action="{{ url()->previous() }}" method="GET">
                        <x-action-button type="submit" icon="arrow_back">
                            Back to Board
                        </x-action-button>
                    </form>
                    <div class="mt-6">
                        <form action="{{ route('dashboard.boards.destroy', $board) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this board?');">
                            @csrf
                            @method('DELETE')
                            <x-action-button type="submit" icon="delete" variant="danger">
                                Delete Board
                            </x-action-button>
                        </form>
                    </div>
                </x-section>

                <!-- Task Card -->
                <div class="bg-card-light dark:bg-card-dark rounded-xl w-full max-w-2xl shadow-xl">
                    <form class="p-6 max-h-[60vh] overflow-y-auto" method="POST"
                        action="{{ route('dashboard.boards.update', $board) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title + Board -->
                        <x-section>
                            <x-input-label for="board-name" value="Board Name"
                                class="block text-base font-semibold text-slate-800 dark:text-slate-200 mb-2" />
                            <x-text-input id="board-name" name="name" type="text"
                                class="form-input text-sm font-thin mb-4" value="{{ old('title', $board->name) }}" />
                            <x-input-label for="board-description" value="Description"
                                class="block text-base font-semibold text-slate-800 dark:text-slate-200 mb-2" />
                            <x-text-input id="board-description" name="description" type="textarea" rows="5"
                                class="form-textarea leading-relaxed text-sm font-thin ">{{ old('description', $board->description) }}
                            </x-text-input>
                        </x-section>


                        <x-section class="flex flex-col justify-end  sm:flex-row gap-4 mb-2">
                            <a href="{{ route('dashboard.index') }}"
                                class ="px-6 py-3 rounded-lg text-slate-700 dark:text-slate-300 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 font-semibold transition-colors">Cancel</a>
                            <button
                                class="px-6 py-3 rounded-lg text-white bg-primary hover:bg-primary/90 font-semibold transition-colors shadow-lg shadow-primary/20"
                                type="submit">Save Changes</button>
                        </x-section>
                    </form>
                </div>
            </x-container>
    </div>
    </main>
    </div>
</x-app-layout>
