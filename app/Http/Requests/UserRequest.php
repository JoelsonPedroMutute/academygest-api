<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
            'status' => 'required|in:active,approved',
            'telefone' => 'required|string|max:255',
            'bi' => 'required|string|max:255',
            'genero' => 'required|in:male,female',
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'password.required' => 'A senha é obrigatória.',
            'role.required' => 'A função é obrigatória.',
            'status.required' => 'O status é obrigatório.',
            'telefone.required' => 'O telefone é obrigatório.',
            'bi.required' => 'O bi é obrigatório.',
            'genero.required' => 'O gênero é obrigatório.',
            'email.unique' => 'O email já está sendo utilizado.',
        ];
    }
}
