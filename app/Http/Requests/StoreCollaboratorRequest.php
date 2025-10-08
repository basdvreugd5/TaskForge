<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCollaboratorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('addCollaborator', $this->route('board'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'exists' ensures the email belongs to a registered user
            'email' => ['required', 'email', 'exists:users,email'],
            // Validate role against only the allowed pivot roles (editor, viewer).
            'role' => ['required', Rule::in(['editor', 'viewer'])], 
        ];
    }
}
