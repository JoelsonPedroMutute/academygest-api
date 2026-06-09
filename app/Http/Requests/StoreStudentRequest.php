<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Student;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        if (!$user) {
            return true; // public registration allowed
        }

        return $user->can('create', Student::class);
    }

    public function rules(): array
    {
        return [
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:6|confirmed',
            'class_id'   => 'nullable|uuid|exists:school_classes,id', // nullable for public registration
            'birth_date' => 'required|date|before:today',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Name is required.',
            'email.required'     => 'Email is required.',
            'email.email'        => 'Email must be valid.',
            'email.unique'       => 'This email is already in use.',
            'password.required'  => 'Password is required.',
            'password.min'       => 'Password must have at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'class_id.uuid'      => 'School class ID must be a valid UUID.',
            'class_id.exists'    => 'Selected school class does not exist.',
            'birth_date.required' => 'Birth date is required.',
            'birth_date.date'    => 'Birth date must be valid.',
            'birth_date.before'  => 'Birth date must be before today.',
        ];
    }
}
