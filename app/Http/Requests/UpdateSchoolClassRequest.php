<?php

namespace App\Http\Requests;

use App\Models\SchoolClass;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        $schoolClass = $this->route('schoolClass');

        if (!$schoolClass instanceof SchoolClass) return false;

        return $this->user()->can('update', $schoolClass);
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('periodo') && !$this->has('semester')) {
            $this->merge([
                'semester' => $this->input('periodo')
            ]);
        }

        if ($this->has('data')) {
            $this->merge($this->input('data'));
        }
    }

    public function rules(): array
    {
        return [
            'name'          => 'sometimes|string|max:255',
            'course_id'     => 'sometimes|exists:courses,id',
            'academic_year' => 'sometimes|string|max:20',
            'semester'      => 'sometimes|integer|min:1|max:2',
            'capacity'      => 'nullable|integer|min:1',
            'shift'         => 'nullable|string|in:morning,afternoon,evening',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string'          => 'Name must be a string.',
            'name.max'             => 'Name must not exceed 255 characters.',
            'course_id.exists'     => 'Selected course does not exist.',
            'academic_year.string' => 'Academic year must be a string.',
            'semester.min'         => 'Semester must be at least 1.',
            'semester.max'         => 'Semester must be at most 2.',
            'capacity.integer'     => 'Capacity must be an integer.',
            'capacity.min'         => 'Capacity must be at least 1.',
            'shift.in'             => 'Shift must be morning, afternoon or evening.',
        ];
    }
}
