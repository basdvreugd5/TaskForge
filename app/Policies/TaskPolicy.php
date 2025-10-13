<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use App\Traits\HasBoardRole;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    use HasBoardRole;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): Response
    {
        return $this->hasAcces($user, $task->board)
            ? Response::allow()
            : Response::deny('You do not have acces to this task.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Board $board): Response
    {
        $role = $this->getRole($user, $board);

        return in_array($role, ['owner', 'editor'])
            ? Response::allow()
            : Response::deny('You do not have acces to this task.');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): Response
    {
        $role = $this->getRole($user, $task->board);

        return in_array($role, ['owner', 'editor'])
            ? Response::allow()
            : Response::deny('You do not have acces to this task.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): Response
    {
        $role = $this->getRole($user, $task->board);

        return in_array($role, ['owner', 'editor'])
            ? Response::allow()
            : Response::deny('You do not have acces to this task.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        return $this->getRole($user, $task->board) === 'owner';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return $this->getRole($user, $task->board) === 'owner';
    }
}
