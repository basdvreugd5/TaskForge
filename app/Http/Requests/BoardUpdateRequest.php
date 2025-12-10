<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoardUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('board') ?? false);
    }
    /**
    * Get the validation rules that apply to the request.
    *
    * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
    */
    public function rules(): array
    {
        return ['name' => ['required', 'string', 'min:10', 'max:255'], 'description' => ['nullable', 'string', 'min:20', 'max:1000']];
    }
}
