<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolClassRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'establishment_id' => 'required|exists:establishments,id',
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'level' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ];
    }
}
