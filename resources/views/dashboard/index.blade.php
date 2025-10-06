<x-app-layout>
    
    <x-slot name="header">
        <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
            {{ __('Dashboard') }}
        </h1>
        <p class= "text-slate-500 dark:text-slate-400 mt-1">
           Welcome back, {{ Auth::user()->name }}! Let's get things done.
    
    </x-slot>

    
        <div class="">
           <!-- Tabs + New Task Button -->
            <div class="border-b border-slate-200 dark:border-slate-800 mb-6">
                <div class="flex justify-between items-center">
                    <nav class="flex gap-8">
                        <a class="flex items-center justify-center border-b-2 border-primary text-primary pb-3">
                            <p class="text-sm font-bold">My Boards</p>
                        </a>
                        <a class="flex items-center justify-center border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary hover:border-primary/50 transition-colors pb-3">
                            <p class="text-sm font-bold">Shared Boards</p>
                        </a>
                        <a class="flex items-center justify-center border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary hover:border-primary/50 transition-colors pb-3">
                            <p class="text-sm font-bold">Timeline Overview</p>
                        </a>
                    </nav>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('dashboard.boards.create') }}" class="flex items-center gap-2 rounded-lg px-2 py-1 text-sm font-medium bg-primary text-white hover:bg-primary/90 transition-colors">
                            <span class="material-symbols-outlined text-base">add</span>
                            New Board
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Search Tasks -->
            <div class="relative mb-8">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500">
                    search
                </span>
                <input class="form-input w-full rounded-lg border-slate-200 dark:border-slate-800 bg-white dark:bg-border-dark/30 focus:ring-primary focus:border-primary pl-12 py-3 text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500" placeholder="Search tasks..." type="text">
            </div>

            
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-slate-900 mb-4 dark:text-white">My Boards</h2>

                @if($boards->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">You don’t have any boards yet.</p>
                @else
                    <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                        @foreach($boards as $board)
                        <li>
                            <a href="{{ route('dashboard.boards.show', $board) }}" class= "">
                                <div class="bg-card-light dark:bg-card-dark rounded-xl p-5 border-2 border-pastel-pink dark:border-pink-900/50 flex flex-col gap-4 shadow-sm hover:shadow-lg transition-shadow duration-300 min-h-[280px]">
                                    <a href="{{ route('dashboard.boards.show', $board) }}" class= "flex flex-col flex-grow">
                                        <div class="flex items-start justify-between">
                                            <h3 class="text-lg font-bold text-slate-900 dark:text-white pr-4">
                                                {{ $board->name }}
                                            </h3>
                                            <span class="material-symbols-outlined text-pink-500 dark:text-pink-400 mt-1">
                                                group
                                            </span>
                                        </div>
                                        <p class="text-sm text-slate-600 dark:text-slate-400 flex-grow line-clamp-3">
                                            {{ $board->description }}
                                        </p>
                                    </a>
                                    <div class="flex items-center justify-between pt-4 border-t border-slate-200 dark:border-slate-800">
                                        <div class="flex items-center gap-2">
                                            <img class="w-8 h-8 rounded-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA_zaJu3CUequj9yYD9CgvVtH3Q7W-85gh0QGgZ5Rp6lx4RZMdE_r4NGfIhvXJwvwCVxVp-AULmmIl4bylfDOXtF87luU88ml4ZMMM4wv7HL9ig0kFpK0YcHPSOSdZgdRUWfnf31wXL1Sun7tp2c1Fw9FzLQDTOl4QEUVdfAEwJDADeSdYiPkILz-ai0kfIEKqAMZU2M_9IGsVluTFFLTIPK_OUH7xII4IsodZLF0QmEC8H6OpXLEaqAGe7Hh_7Iw5LZJr0gq7X9zo">
                                            <div>
                                                <p class="text-xs text-slate-500 dark:text-slate-500">
                                                    Shared by
                                                </p>
                                                <p class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                                    {{ $board->user->name }}
                                                </p>
                                            </div>
                                        </div>
                                        <button class="flex items-center gap-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary transition-colors rounded-lg px-3 py-1.5 -my-1.5 -mx-3 hover:bg-slate-100 dark:hover:bg-slate-800">
                                            <span class="material-symbols-outlined text-base">
                                                manage_accounts
                                            </span>
                                            Manage
                                        </button>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">Today's Focus</h2>
                <div class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-card-dark/40 overflow-hidden shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 dark:bg-card-dark/80 text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider">
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
                                                $statusClasses = match($task->status) {
                                                    'open' => 'bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-300',
                                                    'in_progress' => 'bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300',
                                                    'done' => 'bg-green-100 dark:bg-green-700 text-green-800 dark:text-green-300',
                                                    'review' => 'bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300',
                                                    default => 'bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300',
                                                }
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses }} ">
                                                 {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $priorityClasses = match($task->priority) {
                                                    'low' => 'bg-green-100 dark:bg-green-700 text-green-800 dark:text-green-300',
                                                    'medium' => 'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300',
                                                    'high' => 'bg-red-100 dark:bg-red-700 text-red-800 dark:text-red-300',
                                                    default => 'bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300',
                                                }
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $priorityClasses }} ">
                                                 {{ ucfirst(str_replace('_', ' ', $task->priority)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center text-slate-900 dark:text-white">
                                            {{ $task->hard_deadline->format('M jS') }}
                                        </td>
                                        
                                    </tr>
                                    @empty
                                    @endforelse
      
                            </tbody>      
                        </table>                       
                    </div>
                </div>
                <div class="mt-4">
                    {{  $tasks->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
