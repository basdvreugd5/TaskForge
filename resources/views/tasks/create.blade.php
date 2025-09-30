<x-app-layout>
    <div class="flex h-screen flex-col">

        <!-- Main -->
        <main class="flex-1 p-6 lg:p-10">
            <div class="max-w-4xl mx-auto">

                <!-- Back to Boards Button & Edit Task Button -->
                <div class="flex items-center justify-between mb-8">
                    <a href="{{ url()->previous() }}" 
                       class="flex items-center gap-2 text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">arrow_back</span>
                        <span class="text-sm font-medium">Back to Board</span>
                    </a>
                </div>

                <!-- Task Card -->
                <div class="bg-white dark:bg-card-dark rounded-xl shadow-lg p-8 md:p-12 space-y-12">
                    <form action="{{ route('tasks.store', $board) }}" method="POST" class="space-y-10">
                        @csrf
                        <input type="hidden" name="board_id" value="{{ $board->id }}">
                        <!-- Title + Board -->
                        <div>
                            <x-input-label for="task-title" value="Task Title" class="block text-xl font-semibold text-slate-800 dark:text-slate-200 mb-2" />
                            <x-text-input id="task-title" name="title" type="text" value="Name your task!" class="form-input text-3xl font-bold" />
                        </div>
                        <div>
                            <x-input-label for="task-description" value="Description" class="block text-xl font-semibold text-slate-800 dark:text-slate-200 mb-2" />
                            <x-text-input id="task-description" name="description" type="textarea"  rows="5" class="form-textarea leading-relaxed "> Describe your task..! </x-text-input>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">
                                    Due Dates
                                </h3>
                                <div class="space-y-4">
                                    <div class="relative">
                                        <label class="block text-sm font-medium text-orange-700 dark:text-orange-300 mb-1" for="hard-deadline">
                                            Hard Deadline
                                        </label>
                                        <div class="flex items-center gap-3 rounded-lg bg-orange-100/50 dark:bg-orange-900/30 p-3 border-l-4 border-orange-500/60 dark:border-orange-400/60">
                                            <span class="material-symbols-outlined text-orange-600 dark:text-orange-400 text-xl"> 
                                                error_outline
                                            </span>
                                            <input class="form-input !bg-transparent !border-0 !p-0 !ring-0" id="hard-deadline" name="hard_deadline" type="date" value="{{ old('hard_deadline') ?? ($task->hard_deadline?->format('Y-m-d') ?? '') }}"> </input>
                                        </div>
                                    </div>
                                    <div class="relative">
                                        <label class="block text-sm font-medium text-blue-700 dark:text-blue-300 mb-1" for="soft-due-date">
                                            Soft Due Date (Optional)
                                        </label>
                                        <div class="flex items-center gap-3 rounded-lg bg-blue-100/50 dark:bg-blue-900/30 p-3 border-l-4 border-blue-400/50 dark:border-blue-600/50">
                                            <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-xl"> 
                                                event_available
                                            </span>
                                            <input class="form-input !bg-transparent !border-0 !p-0 !ring-0" id="soft-due-date" name="soft_due_date" type="date" value="{{ old('soft_due_date') ?? ($task->soft_due_date?->format('Y-m-d') ?? '') }}"> </input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">
                                    Details
                                </h3>
                                <x-form-select 
                                    name="status" 
                                    label="Status" 
                                    :options="[
                                        'open' => 'Open',
                                        'in_progress' => 'In Progress',
                                        'review' => 'Review',
                                        'done' => 'Done'
                                    ]"
                                    :selected="$task->status ?? null"
                                />

                                <x-form-select 
                                    name="priority" 
                                    label="Priority" 
                                    :options="[
                                        'low' => 'Low',
                                        'medium' => 'Medium',
                                        'high' => 'High'
                                    ]"
                                    :selected="$task->priority ?? null"
                                />
                            </div>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mb-5">
                                Checklist
                            </h2>
                            <div x-data="{ subtasks: [] }" class="space-y-3">
                                <!-- Loop over subtasks -->
                                <template x-for="(subtask, index) in subtasks" :key="index">
                                    <div class="flex items-center space-x-4 p-3 rounded-lg bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800">
                                        <!-- Checkbox -->
                                        <input
                                            type="checkbox"
                                            x-model="subtask.is_completed"
                                            :name="`checklist[${index}][is_completed]`"
                                            value="1"
                                            class="h-6 w-6 rounded-md border-slate-400 dark:border-slate-600 text-primary focus:ring-primary/50 bg-transparent dark:bg-slate-800 cursor-pointer flex-shrink-0"
                                        >

                                        <!-- Subtask title -->
                                        <input
                                            type="text"
                                            x-model="subtask.title"
                                            :name="`checklist[${index}][title]`"
                                            placeholder="Write a subtask..."
                                            class="form-input !p-2 !bg-transparent !border-0 focus:!ring-2 focus:!ring-primary/50 text-slate-700 dark:text-slate-300 flex-grow"
                                        >

                                        <!-- Delete button -->
                                        <button type="button" @click="subtasks.splice(index, 1)"
                                            class="p-2 rounded-full hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-500 dark:text-slate-400">
                                            <span class="material-symbols-outlined text-base">delete</span>
                                        </button>
                                    </div>
                                </template>

                                <!-- Add button -->
                                <button type="button" @click="subtasks.push({ title: '', is_completed: false })"
                                    class="w-full flex items-center justify-center gap-2 p-3 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 rounded-lg transition-colors border-2 border-dashed border-slate-300 dark:border-slate-700">
                                    <span class="material-symbols-outlined">add</span>
                                    <span>Add subtask</span>
                                </button>
                            </div>
                        </div>
                        <div class="mt-12 flex justify-end gap-4">
                            <a href="{{ route('boards.show', $board) }}" class ="px-6 py-3 rounded-lg text-slate-700 dark:text-slate-300 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 font-semibold transition-colors">Cancel</a>
                            <button class="px-6 py-3 rounded-lg text-white bg-primary hover:bg-primary/90 font-semibold transition-colors shadow-lg shadow-primary/20" type="submit">Save Changes</button>
                        </div>


                            
                    </form>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>