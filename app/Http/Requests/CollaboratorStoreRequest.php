<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CollaboratorStoreRequest extends FormRequest
{
    /**
     * Determine if the user can add a collaborator.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('addCollaborator', $this->route('board')) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email', 'max:255', 'min:5', 'string'],
            'role' => ['required', Rule::in(['editor', 'viewer']), 'string'],
        ];
    }
}
