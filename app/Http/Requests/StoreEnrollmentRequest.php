<?php

namespace App\Http\Requests;

use App\Models\Enrollment;
use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()
            ? $this->user()->can('create', Enrollment::class)
            : true;
    }

    public function rules(): array
    {
        return [
            'student_id'       => 'required|integer|exists:students,id',
            'course_id'        => 'required|integer|exists:courses,id',
            'school_class_id'  => 'required|integer|exists:school_classes,id',
            'academic_year'    => 'required|string|max:20',
            'semester'         => 'required|integer|min:1|max:2',

            'capacity'         => 'nullable|integer|min:1',
            'shift'            => 'nullable|string|in:morning,afternoon,evening',

            'status'           => 'nullable|in:active,suspended,cancelled,completed',
            'enrollment_date'  => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required'      => 'Student is required.',
            'student_id.exists'        => 'Selected student does not exist.',

            'course_id.required'       => 'Course is required.',
            'course_id.exists'         => 'Selected course does not exist.',

            'school_class_id.required' => 'School class is required.',
            'school_class_id.exists'   => 'Selected school class does not exist.',

            'academic_year.required'   => 'Academic year is required.',

            'semester.required'        => 'Semester is required.',
            'semester.min'             => 'Semester must be at least 1.',
            'semester.max'             => 'Semester must be at most 2.',

            'capacity.integer'         => 'Capacity must be a number.',
            'capacity.min'             => 'Capacity must be at least 1.',

            'shift.in'                 => 'Shift must be morning, afternoon or evening.',

            'status.in'                => 'Invalid enrollment status.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('periodo') && !$this->has('semester')) {
            $this->merge([
                'semester' => $this->input('periodo'),
            ]);
        }

        if ($this->has('data') && is_array($this->input('data'))) {
            $this->merge($this->input('data'));
        }
    }
}
