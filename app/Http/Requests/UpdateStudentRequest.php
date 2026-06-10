<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $student = $this->route('student');

        return $this->user()
            ? $this->user()->can('update', $student)
            : false;
    }

    public function rules(): array
    {
        $student = $this->route('student');

        return [
            'name'            => 'sometimes|string|max:255',
            'email'           => 'sometimes|email|max:255|unique:users,email,' . optional($student->user)->id,
            'password'        => 'sometimes|nullable|string|min:6|confirmed',

            'class_id'        => 'sometimes|uuid|exists:school_classes,id', // ← era school_class_id e integer

            'birth_date'      => 'sometimes|date|before:today',

            'student_number'  => 'sometimes|string|max:20|unique:students,student_number,' . $student->id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.string'             => 'Name must be a string.',
            'name.max'                => 'Name must not exceed 255 characters.',

            'email.email'             => 'Email must be valid.',
            'email.unique'            => 'This email is already in use.',

            'password.min'            => 'Password must be at least 6 characters.',
            'password.confirmed'      => 'Password confirmation does not match.',

            'school_class_id.integer' => 'School class must be an integer.',
            'school_class_id.exists'  => 'Selected school class does not exist.',

            'birth_date.date'         => 'Birth date must be a valid date.',
            'birth_date.before'       => 'Birth date must be before today.',

            'student_number.string'   => 'Student number must be a string.',
            'student_number.max'      => 'Student number must not exceed 20 characters.',
            'student_number.unique'   => 'This student number is already in use.',
        ];
    }
}
