<?php

namespace App\Http\Requests;

use App\Models\Board;
use Illuminate\Foundation\Http\FormRequest;

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
}
