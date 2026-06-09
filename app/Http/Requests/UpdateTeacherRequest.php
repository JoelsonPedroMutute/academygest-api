<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        $teacher = $this->route('teacher');

        // Self update (teacher updating own profile)
        if (!$teacher) {
            return Auth::check() && Auth::user()->role === 'teacher';
        }

        return $this->user()
            ? $this->user()->can('update', $teacher)
            : false;
    }

    public function rules(): array
    {
        $teacher = $this->route('teacher');
        $userId = $teacher?->user_id;

        return [
            'name'        => 'sometimes|string|max:255|unique:users,name,' . $userId,
            'email'       => 'sometimes|email|max:255|unique:users,email,' . $userId,
            'phone'       => 'sometimes|nullable|string|max:20',
            'specialty'   => 'sometimes|nullable|string|max:255',
            'birth_date'  => 'sometimes|nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string'       => 'Name must be a string.',
            'name.max'          => 'Name must not exceed 255 characters.',
            'name.unique'       => 'This name is already in use.',

            'email.email'       => 'Email must be valid.',
            'email.unique'      => 'This email is already in use.',

            'phone.string'      => 'Phone must be a string.',
            'phone.max'         => 'Phone must not exceed 20 characters.',

            'specialty.string'  => 'Specialty must be a string.',
            'specialty.max'     => 'Specialty must not exceed 255 characters.',

            'birth_date.date'   => 'Birth date must be a valid date.',
        ];
    }
}
