<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()
            ? $this->user()->can('create', User::class)
            : false;
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',

            'role'     => 'required|in:admin,user,teacher,student',
            'status'   => 'required|in:active,inactive,pending',

            'phone'    => 'nullable|string|max:20',

            // Optional identity fields (only if your system really needs them)
            'bi'       => 'nullable|string|max:50',
            'gender'   => 'nullable|in:male,female',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Name is required.',
            'email.required'    => 'Email is required.',
            'email.email'       => 'Email must be valid.',
            'email.unique'      => 'Email is already in use.',

            'password.required' => 'Password is required.',
            'password.min'      => 'Password must be at least 8 characters.',
            'password.confirmed'=> 'Password confirmation does not match.',

            'role.required'     => 'Role is required.',
            'role.in'           => 'Invalid role.',

            'status.required'   => 'Status is required.',
            'status.in'         => 'Invalid status.',

            'phone.string'      => 'Phone must be a string.',

            'gender.in'         => 'Gender must be male or female.',
        ];
    }
}