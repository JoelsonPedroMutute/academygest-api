<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Teacher;

class StoreTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|string|min:6|confirmed',
            'phone'           => 'nullable|string|max:20',
            'specialty'       => 'nullable|string|max:255',
            'birth_date'      => 'nullable|date|before:today',
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
            'password.min'       => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'birth_date.date'    => 'Birth date must be valid.',
            'birth_date.before'  => 'Birth date must be before today.',
        ];
    }
}
