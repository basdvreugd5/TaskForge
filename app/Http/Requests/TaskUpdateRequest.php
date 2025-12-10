<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $task = $this->route('task');

        return $this->user()?->can('update', $task);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
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
}
