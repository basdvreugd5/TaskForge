<x-app-layout>
    <x-container class="max-w-4xl mx-auto p-6 lg:p-10">
        <!-- Back to Boards Button -->
        <div class="flex items-center justify-between mb-8">
            <form action="{{ url()->previous() }}" method="GET">
                <x-action-button type="submit" icon="arrow_back">
                    Back to Board
                </x-action-button>
            </form>
        </div>
        <x-card class="" variant=wide>
            <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">
                        Manage Collaborators
                    </h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        For "{{ $board->name }}" board
                    </p>
                </div>
            </div>
            <!-- Session Status Messages (Success/Error) -->
            @if (session('success'))
                <div class="p-4 mx-6 mt-4 bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg font-medium"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="p-4 mx-6 mt-4 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 rounded-lg font-medium"
                    role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->has('email'))
                <div class="p-4 mx-6 mt-4 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 rounded-lg font-medium"
                    role="alert">
                    {{ $errors->first('email') }}
                </div>
            @endif
            <!-- Current Collaborators List -->
            <div class="p-6 max-h-[60vh] overflow-y-auto">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">
                    Current Collaborators
                </h3>
                <div class="space-y-3">
                    @foreach ($board->collaborators as $collaborator)
                        @php
                            $role = $collaborator->pivot->role;
                            $isOwner = $collaborator->id === $board->user_id;
                            $isCurrentUser = $collaborator->id === Auth::id();

                            $displayRole = $isOwner ? 'owner' : $role ?? 'member';
                            // Helper for dynamic Tailwind classes.
                            $roleClasses = [
                                'owner' => 'bg-pastel-pink text-pink-600 dark:bg-pink-900/50 dark:text-pink-300',
                                'editor' =>
                                    'bg-role-editor text-role-editor-text dark:bg-role-editor-dark dark:text-role-editor-text-dark',
                                'viewer' =>
                                    'bg-role-viewer text-role-viewer-text dark:bg-role-viewer-dark dark:text-role-viewer-text-dark',
                                'member' => 'bg-pastel-blue text-blue-600 dark:bg-blue-900/50 dark:text-blue-300',
                            ];

                            $roleClass =
                                $roleClasses[$displayRole] ??
                                'bg-slate-200 text-slate-800 dark:bg-slate-700 dark:text-slate-300';
                            $roleText = ucfirst($displayRole);
                        @endphp
                        <div
                            class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <div class="flex items-center gap-4">
                                {{-- Use actual user avatar when implemented --}}
                                <img alt="{{ $collaborator->name }}'s avatar" class="w-10 h-10 rounded-full"
                                    src="{{ $collaborator->profile_photo_url ?? 'https://placehold.co/40x40/5a67d8/ffffff?text=' . substr($collaborator->name, 0, 1) }}" />
                                <div>
                                    <p class="font-semibold text-slate-800 dark:text-slate-200">
                                        {{ $isCurrentUser ? 'You' : $collaborator->name }}
                                    </p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">
                                        {{ $collaborator->email }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                {{-- Display Role with dynamic classes --}}
                                <span class="{{ $roleClass }} text-xs font-bold px-3 py-1 rounded-full">
                                    {{ $roleText }}
                                </span>
                                <div class="flex items-center gap-2">
                                    {{-- Edit Role Button (Disabled for owner/self for simplicity) --}}
                                    <x-icon-button icon="edit" :disabled="$isOwner || $isCurrentUser"
                                        color="{{ $isOwner || $isCurrentUser ? 'slate' : 'default' }}" />

                                    {{-- Remove Collaborator Button --}}
                                    @if (!$isOwner && !$isCurrentUser)
                                        <form method="POST"
                                            action="{{ route('dashboard.collaborators.destroy', [$board, $collaborator]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <x-icon-button icon="delete" type="submit" color="red"
                                                :disabled="false" />
                                        </form>
                                    @else
                                        <x-icon-button icon="delete" type="submit" color="slate" :disabled="true" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Add New Collaborator Form -->
            <div class="p-6 border-t border-slate-200 dark:border-slate-800">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">
                    Add New Collaborator
                </h3>
                <form method="POST" action="{{ route('dashboard.collaborators.store', $board) }}">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-4">
                        <!-- Email Input -->
                        <div class="relative flex-grow">
                            <span
                                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                person_add
                            </span>
                            <x-text-input name="email" type="email" placeholder="Enter user email..."
                                class="w-full pl-10 pr-4 py-2.5" required>
                            </x-text-input>
                        </div>
                        <!-- Role Select -->
                        <div class="relative">
                            <select name="role"
                                class="appearance-none w-full sm:w-auto bg-background-light dark:bg-background-dark border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 py-2.5 pl-3 pr-10 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition">
                                <option value="editor">Editor</option>
                                <option value="viewer">Viewer</option>
                            </select>
                            {{-- <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span> --}}
                            @error('role')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="bg-primary text-white font-bold py-2.5 px-6 rounded-lg hover:bg-primary/90 transition-colors flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">add</span>
                            Add Collaborator
                        </button>
                    </div>
                </form>
            </div>
        </x-card>
    </x-container>
</x-app-layout>
