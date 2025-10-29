@props(['board', 'role' => null, 'showManage' => false, 'showLeave' => false, 'context' => 'default'])

@php
    if (!$role) {
        $role = $board->pivot->role ?? null;

        if (!$role) {
            $collaborator = $board->collaborators->firstWhere('id', auth()->id());
            if ($collaborator) {
                $role = $collaborator->pivot->role ?? null;
            }
        }

        $role = $role ?? ($board->user_id === auth()->id() ? 'owner' : 'viewer');
    }

    $role = in_array($role, ['owner', 'editor', 'viewer']) ? $role : 'viewer';

    $roleColors = [
        'owner' => ' text-pink-500 dark:text-pink-400 ',
        'editor' => ' text-blue-500 dark:text-blue-400 ',
        'viewer' => ' text-green-500 dark:text-green-400 ',
    ];

    if ($context === 'shared') {
        $icon = 'group';
    } elseif ($role === 'owner') {
        $icon = $board->collaborators_count > 1 ? 'group' : ' person';
    } else {
        $icon = 'group';
    }
    $roleClass = '';
@endphp
@switch($role)
    @case('owner')
        @php $roleClass = 'border-pastel-pink dark:border-pink-900/50 text-pink-500 dark:text-pink-400 hover:border-pink-500/50'; @endphp
    @break

    @case('editor')
        @php $roleClass = 'border-pastel-blue dark:border-blue-900/50 text-blue-500 dark:text-blue-400 hover:border-blue-500/50'; @endphp
    @break

    @case('viewer')
        @php $roleClass = 'border-pastel-green dark:border-green-900/50 text-green-500 dark:text-green-400 hover:border-green-500/50'; @endphp
    @break

    @default
@endswitch

<a href="{{ route('dashboard.boards.show', $board) }}">
    <x-card class="{{ $roleClass }}">

        <div class="flex items-start justify-between">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white pr-4">
                {{ Str::limit($board->name, 30) }}
            </h3>

            <span class="material-symbols-outlined mt-1{{ $roleColors[$role] ?? '' }}">
                {{ $icon }}
            </span>

        </div>

        <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-5">
            {{ Str::limit($board->description, 180) }}
        </p>
        <div class="flex items-center justify-between pt-4 border-t border-slate-200 dark:border-slate-800 mt-auto">
            <div class="flex items-center gap-2">
                <img class="w-8 h-8 rounded-full"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuA_zaJu3CUequj9yYD9CgvVtH3Q7W-85gh0QGgZ5Rp6lx4RZMdE_r4NGfIhvXJwvwCVxVp-AULmmIl4bylfDOXtF87luU88ml4ZMMM4wv7HL9ig0kFpK0YcHPSOSdZgdRUWfnf31wXL1Sun7tp2c1Fw9FzLQDTOl4QEUVdfAEwJDADeSdYiPkILz-ai0kfIEKqAMZU2M_9IGsVluTFFLTIPK_OUH7xII4IsodZLF0QmEC8H6OpXLEaqAGe7Hh_7Iw5LZJr0gq7X9zo"
                    alt="{{ $board->user->name }}">
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-500">
                        {{ $role === 'owner' ? 'Owned by' : 'Shared by' }}
                    </p>
                    <p class="text-sm font-medium text-slate-700 dark:text-slate-300">
                        {{ Str::limit($board->user->name, 10) }}
                    </p>
                </div>
            </div>
            @if ($showManage)
                <form action="{{ route('dashboard.boards.manage.collaborators', $board) }}" method="GET">
                    <x-action-button type="submit" icon="manage_accounts">
                        Manage
                    </x-action-button>
                </form>
            @elseif ($showLeave)
                <form action="{{ route('dashboard.boards.leave', $board) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to leave the board: {{ $board->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="flex items-center gap-2 text-sm font-medium text-red-500 dark:text-red-400 hover:text-red-600 dark:hover:text-red-500 transition-colors rounded-lg px-3 py-1.5 -my-1.5 -mx-3 hover:bg-red-50 dark:hover:bg-slate-800/50">
                        <span class="material-symbols-outlined text-base">logout</span>
                        Leave
                    </button>
                </form>
            @endif
        </div>
    </x-card>
</a>
