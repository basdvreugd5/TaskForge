<?php

namespace App\Http\Requests;

use App\Models\Board;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class BoardStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.*
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create', Board::class);

    }

    /**
     * Get the validation rules that apply to the request.*
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>*
     */
    public function rules(): array
    {
        return ['name' => ['required', 'string', 'min:10', 'max:255'], 'description' => ['nullable', 'string', 'min:20', 'max:1000']];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($this->user()->boards()->where('name', $this->input('name'))->exists()) {
                    $validator->errors()->add('name', 'You already have a board with this name.');
                }

                if ($this->user()->boards()->count() >= 10) {
                    $validator->errors()->add('name', 'Board limit reached. Upgrade to create more.');
                }
            },
        ];
    }
}
