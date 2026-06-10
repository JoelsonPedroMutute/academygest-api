<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Disciplina;
use App\Models\Subject;

class StoreSubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Subject::class);
        // return false; --- IGNORE ---
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:subjects',
            'description' => 'nullable|string',
            'course_id' => 'sometimes|exists:courses,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The subject name is required.',
            'name.string' => 'The subject name must be a string.',
            'name.max' => 'The subject name must not exceed 255 characters.',
            'name.unique' => 'This subject name is already in use.',
            'description.string' => 'The subject description must be a string.',
        ];
    }
}
