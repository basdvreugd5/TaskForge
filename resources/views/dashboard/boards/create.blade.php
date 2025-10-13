<x-app-layout>
    <div class="flex h-screen flex-col">

        <!-- Main -->
        <main class="flex-1 p-6 lg:p-10">
            <div class="max-w-4xl mx-auto">

                <!-- Back to Boards Button & Edit Task Button -->
                <div class="flex items-center justify-between mb-8">
                    {{-- <a href="{{ url()->previous() }}" 
                       class="flex items-center gap-2 text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">arrow_back</span>
                        <span class="text-sm font-medium">Back to Board</span>
                    </a> --}}
                    <form action="{{ url()->previous() }}" method="GET">
                        <x-action-button type="submit" icon="arrow_back">
                            Back to Board
                        </x-action-button>
                    </form>
                </div>

                <!-- Task Card -->
                <div class="bg-white dark:bg-card-dark rounded-xl shadow-lg p-8 md:p-12 space-y-12">
                    <form class="space-y-10" method="POST" action="{{ route('dashboard.boards.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Title + Board -->
                        <div>
                            <x-input-label for="board-name" value="Board Name"
                                class="block text-xl font-semibold text-slate-800 dark:text-slate-200 mb-2" />
                            <x-text-input id="board-name" name="name" type="text" placeholder="Name your Board!"
                                class="form-input text-3xl font-bold" />
                        </div>
                        <div>
                            <x-input-label for="board-description" value="Description"
                                class="block text-xl font-semibold text-slate-800 dark:text-slate-200 mb-2" />
                            <x-text-input id="board-description" name="description" type="textarea" rows="5"
                                class="form-textarea leading-relaxed " placeholder="Describe your Board..!">
                            </x-text-input>
                        </div>
                        <div>
                            <label class="block text-xl font-medium text-slate-800 dark:text-slate-200 mb-3">Board
                                Image</label>
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                                <div class="shrink-0">
                                    <img alt="Current board image" class="h-40 w-40 object-cover rounded-xl shadow-soft"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuATWGgdHGvHUxdH4bGXwwDKhzk9onwjjgyPLrjN8MkbhyYJPX-QasobjsUpAIRBDPOK7LGlhY3WJdbD-ja1r1XY2v4S7yyh5RgD8WBTWN7Of-2ApyST9o2AJcJAgcQqBjM1fEMgraWvZB0XJ2gVHvTrHh3WRx4L6u8nO3XDpgNqLgGovarMAAwiNBJWvSTp1ljW48GGKjetzA8D5PiYSoqgGF_-gFA_SPs9mmoFw35IdOJtnKXARPOR4-4A74K29u2GHMWahdeM_IQ" />
                                </div>
                                <div class="flex-1 w-full">
                                    <div
                                        class="border-2 border-dashed border-muted-light dark:border-muted-dark rounded-xl p-6 text-center transition-colors hover:border-primary dark:hover:border-primary bg-background-light dark:bg-background-dark/50 hover:bg-primary/5 dark:hover:bg-primary/10 cursor-pointer">
                                        <div class="flex flex-col items-center justify-center space-y-2">
                                            <span
                                                class="material-symbols-outlined text-5xl text-primary">cloud_upload</span>
                                            <p class="text-lg font-semibold text-slate-700 dark:text-slate-300">Click to
                                                upload or drag &amp; drop</p>
                                            <p class="text-sm text-slate-500 dark:text-slate-400">SVG, PNG, JPG or GIF
                                                (max. 800x400px)</p>
                                            <input class="sr-only" type="file" />
                                        </div>
                                    </div>
                                    <div class="mt-4 hidden">
                                        <div
                                            class="flex items-center justify-between bg-slate-100 dark:bg-slate-800 p-3 rounded-lg">
                                            <div class="flex items-center gap-3">
                                                <span
                                                    class="material-symbols-outlined text-green-500">check_circle</span>
                                                <span
                                                    class="text-sm font-medium text-slate-700 dark:text-slate-300">new_image.jpg</span>
                                            </div>
                                            <button class="p-1 rounded-full hover:bg-slate-200 dark:hover:bg-slate-700"
                                                type="button">
                                                <span class="material-symbols-outlined text-sm">close</span>
                                            </button>
                                        </div>
                                        <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-1.5 mt-2">
                                            <div class="bg-primary h-1.5 rounded-full" style="width: 75%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="mt-12 flex justify-end gap-4">
                    <a href="{{ route('dashboard.index') }}"
                        class ="px-6 py-3 rounded-lg text-slate-700 dark:text-slate-300 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 font-semibold transition-colors">Cancel</a>
                    <button
                        class="px-6 py-3 rounded-lg text-white bg-primary hover:bg-primary/90 font-semibold transition-colors shadow-lg shadow-primary/20"
                        type="submit">Save Changes</button>
                </div>



                </form>
            </div>
    </div>
    </main>
    </div>
</x-app-layout>
