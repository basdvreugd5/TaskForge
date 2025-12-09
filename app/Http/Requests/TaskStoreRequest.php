<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class TaskStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $board = $this->route('board');

        return $this->user()?->can('create', [Task::class, $board]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1220'],
            'status' => ['required', 'string', 'in:open,in_progress,review,done'],
            'priority' => ['required', 'string', 'in:low,medium,high'],
            'hard_deadline' => ['required', 'date'],
            'soft_due_date' => ['nullable', 'date'],
            'checklist' => ['nullable', 'array'],
            'checklist.*.title' => ['required_with:checklist', 'string', 'max:255'],
            'checklist.*.is_completed' => ['boolean'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $board = $this->route('board');

                if ($board && $board->tasks()->count() >= 200) {
                    $validator->errors()->add('title', 'Task limit reached for this board.');
                }
            },
        ];
    }
}
