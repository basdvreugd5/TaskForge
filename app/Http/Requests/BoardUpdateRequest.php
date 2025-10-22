<?php

namespace App\Http\Requests;

use App\Models\Board;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class BoardUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('board') ?? false);
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return ['name' => ['required', 'string', 'min:10', 'max:255'], 'description' => ['nullable', 'string', 'min:20', 'max:1000']];
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Get the validation callbacks that should run after validation.
     *
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {

                $boardId = $this->board?->id;

                if (! $boardId) {
                    $boardParam = $this->route('board') ?? $this->route('id');
                    $boardId = is_object($boardParam) ? $boardParam->id : $boardParam;
                }

                $userId = $this->user()->id;

                $duplicate = Board::where('user_id', $userId)
                    ->where('name', $this->input('name'))
                    ->where('id', '!=', $boardId)
                    ->exists();

                if ($duplicate) {
                    $validator->errors()->add('name', 'You already have a board with this name.');
                }
            },
        ];
    }
}
