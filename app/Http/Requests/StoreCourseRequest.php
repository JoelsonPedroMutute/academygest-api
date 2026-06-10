<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Course::class);
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255|unique:courses,name',
            'duration'    => 'nullable|integer|min:1|max:10',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Course name is required.',
            'name.string'   => 'Course name must be a string.',
            'name.max'      => 'Course name must not exceed 255 characters.',
            'name.unique'   => 'This course name is already in use.',
            'description.string' => 'Description must be a string.',
            'duration.integer'   => 'Duration must be an integer.',
            'duration.min'       => 'Duration must be at least 1 year.',
            'duration.max'       => 'Duration must not exceed 10 years.',
        ];
    }
}
