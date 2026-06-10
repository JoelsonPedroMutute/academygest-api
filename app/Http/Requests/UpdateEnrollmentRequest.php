<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $enrollment = $this->route('enrollment');

        return $this->user()
            ? $this->user()->can('update', $enrollment)
            : false;
    }

    public function rules(): array
    {
        return [
            'student_id'      => 'sometimes|integer|exists:students,id',
            'school_class_id' => 'sometimes|integer|exists:school_classes,id',
            'academic_year'   => 'sometimes|string|max:20',
            'semester'        => 'sometimes|integer|min:1|max:2',
            'enrollment_date' => 'sometimes|nullable|date',
            'status'          => 'sometimes|in:active,suspended,cancelled,completed',
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.exists'      => 'Selected student does not exist.',
            'school_class_id.exists' => 'Selected school class does not exist.',
            'enrollment_date.date'   => 'Enrollment date must be a valid date.',
            'status.in'              => 'Status must be active, suspended, cancelled or completed.',
        ];
    }
}
