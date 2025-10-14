<x-app-layout>
    <div class="flex h-screen flex-col">

        <!-- Main -->
        <main class="flex-1 p-6 lg:p-10">
            <x-container class="max-w-4xl mx-auto">

                <!-- Back to Boards Button -->
                <x-section class="flex items-center justify-between mb-8">
                    <form action="{{ url()->previous() }}" method="GET">
                        <x-action-button type="submit" icon="arrow_back">
                            Back to Board
                        </x-action-button>
                    </form>
                    <div class="mt-6">
                        <form action="{{ route('dashboard.tasks.destroy', $task) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this task?');">
                            @csrf
                            @method('DELETE')
                            <x-action-button type="submit" icon="delete" variant="danger">
                                Delete Task
                            </x-action-button>
                        </form>
                    </div>
                </x-section>

                <!-- Task Card -->
                <div class="bg-white dark:bg-card-dark rounded-xl shadow-lg p-8 md:p-12 space-y-12">
                    <form id="update-task-form" action="{{ route('dashboard.tasks.update', $task) }}" method="POST"
                        class="space-y-10">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="board_id" value="{{ $board->id }}">

                        <!-- Title -->
                        <div>
                            <x-input-label for="task-title" value="Task Title"
                                class="block text-xl font-semibold text-slate-800 dark:text-slate-200 mb-1" />
                            <x-text-input id="task-title" name="title" type="text"
                                value="{{ old('title', $task->title) }}" class="form-input text-sm mb-4" />

                            <x-input-label for="task-description" value="Description"
                                class="block text-xl font-semibold text-slate-800 dark:text-slate-200 mb-1" />
                            <textarea id="task-description" name="description" rows="3"
                                class="form-textarea text-sm w-full pr-4 py-2.5 rounded-lg bg-background-light dark:bg-background-dark border border-slate-300 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-primary transition">{{ old('description', $task->description) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Due Dates -->
                            <div>
                                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Due Dates</h3>
                                <div class="space-y-4">
                                    <div class="relative">
                                        <label
                                            class="block text-sm font-medium text-orange-700 dark:text-orange-300 mb-1"
                                            for="hard-deadline">
                                            Hard Deadline
                                        </label>
                                        <div
                                            class="flex items-center gap-3 rounded-lg bg-orange-100/50 dark:bg-orange-900/30 p-3 border-l-4 border-orange-500/60 dark:border-orange-400/60">
                                            <span
                                                class="material-symbols-outlined text-orange-600 dark:text-orange-400 text-xl">error_outline</span>
                                            <input class="form-input !bg-transparent !border-0 !p-0 !ring-0"
                                                id="hard-deadline" name="hard_deadline" type="date"
                                                value="{{ old('hard_deadline', $task->hard_deadline?->format('Y-m-d') ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="relative">
                                        <label class="block text-sm font-medium text-blue-700 dark:text-blue-300 mb-1"
                                            for="soft-due-date">
                                            Soft Due Date (Optional)
                                        </label>
                                        <div
                                            class="flex items-center gap-3 rounded-lg bg-blue-100/50 dark:bg-blue-900/30 p-3 border-l-4 border-blue-400/50 dark:border-blue-600/50">
                                            <span
                                                class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-xl">event_available</span>
                                            <input class="form-input !bg-transparent !border-0 !p-0 !ring-0"
                                                id="soft-due-date" name="soft_due_date" type="date"
                                                value="{{ old('soft_due_date', $task->soft_due_date?->format('Y-m-d') ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status & Priority -->
                            <div>
                                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Details</h3>
                                <x-form-select name="status" label="Status" :options="[
                                    'open' => 'Open',
                                    'in_progress' => 'In Progress',
                                    'review' => 'Review',
                                    'done' => 'Done',
                                ]" :selected="old('status', $task->status)" />
                                <x-form-select name="priority" label="Priority" :options="['low' => 'Low', 'medium' => 'Medium', 'high' => 'High']" :selected="old('priority', $task->priority)" />
                            </div>
                        </div>

                        <!-- Checklist -->
                        <div>
                            <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mb-5">Checklist</h2>
                            <div x-data='{
                                    subtasks: @json(old('checklist', $task->checklist))
                            }'
                                class="space-y-3">
                                <!-- Loop over subtasks -->
                                <template x-for="(subtask, index) in subtasks" :key="index">
                                    <div
                                        class="flex items-center space-x-4 p-3 rounded-lg bg-white dark:bg-border-dark/30 shadow-sm border border-slate-200 dark:border-slate-800">
                                        <input type="checkbox" x-model="subtask.is_completed"
                                            :name="`checklist[${index}][is_completed]`" value="1"
                                            class="h-6 w-6 rounded-md border-slate-400 dark:border-slate-600 text-primary focus:ring-primary/50 bg-transparent dark:bg-slate-800 cursor-pointer flex-shrink-0">
                                        <input type="text" x-model="subtask.title"
                                            :name="`checklist[${index}][title]`" placeholder="Write a subtask..."
                                            class="form-input !p-2 !bg-transparent !border-0 focus:!ring-2 focus:!ring-primary/50 text-slate-700 dark:text-slate-300 flex-grow">
                                        <x-icon-button icon="delete" type="submit" size="base"
                                            @click="subtasks.splice(index, 1)" :disabled="false" />
                                    </div>
                                </template>

                                <!-- Add new subtask -->
                                <button type="button" @click="subtasks.push({ title: '', is_completed: false })"
                                    class="w-full flex items-center justify-center gap-2 p-3 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 rounded-lg transition-colors border-2 border-dashed border-slate-300 dark:border-slate-700">
                                    <span class="material-symbols-outlined">add</span>
                                    <span>Add subtask</span>
                                </button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-12 flex justify-between items-center">

                            <!-- Cancel + Save on the right -->
                            <div class="flex gap-4">
                                <a href="{{ route('dashboard.boards.show', $board) }}"
                                    class="px-6 py-3 rounded-lg text-slate-700 dark:text-slate-300 bg-slate-200 dark:bg-border-dark/30 hover:bg-slate-300 dark:hover:bg-slate-700 font-semibold transition-colors">
                                    Cancel
                                </a>
                                <button type="submit" form="update-task-form"
                                    class="px-6 py-3 rounded-lg text-white bg-primary hover:bg-primary/90 font-semibold transition-colors shadow-lg shadow-primary/20">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </x-container>
        </main>
    </div>
</x-app-layout>
