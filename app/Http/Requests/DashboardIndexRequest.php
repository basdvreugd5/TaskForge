<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DashboardIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    // ----------------------------------------------------------

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search' => 'nullable|string:max:255',
            'type' => 'nullable|in:owned,shared',
        ];
    }
    // ----------------------------------------------------------

    /**
     * Summary of getFilters
     *
     * @return array
     */
    public function getFilters()
    {
        $filters = $this->only('search', 'type');
        $filters['type'] ??= 'owned';

        return $filters;
    }
}
