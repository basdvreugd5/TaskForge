<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CollaboratorStoreRequest extends FormRequest
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
            'email' => ['required', 'email', 'exists:users,email', 'max:255', 'min:5', 'string'],
            'role' => ['required', Rule::in(['editor', 'viewer']), 'string'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $board = $this->route('board');
            $collaborator = User::where('email', $this->email)->first();

            if (! $collaborator) {
                $validator->errors()->add('error', 'No user found with that email adress.');

                return;
            }

            if ($collaborator->id === $board->user_id) {
                $validator->errors()->add('email', 'The board owner cannot be added as a collaborator');
            }

            if ($board->collaborators()->where('user_id', $collaborator->id)->exists()) {
                $validator->errors()->add('email', 'This user is already a collaborator');
            }
        });
    }
}
