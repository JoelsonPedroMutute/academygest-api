<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Docente;

class StoreDocenteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Docente::class);
        // return false; --- IGNORE ---
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'data_nascimento' => 'required|date|before:today',
            'especialidade' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do docente é obrigatório.',
            'name.string' => 'O nome do docente deve ser uma string.',
            'name.max' => 'O nome do docente deve ter no máximo 255 caracteres.',
            'email.required' => 'O email do docente é obrigatório.',
            'email.email' => 'O email do docente deve ser um email válido.',
            'email.unique' => 'Este email já está em uso.',
            'password.required' => 'A senha do docente é obrigatória.',
            'password.string' => 'A senha do docente deve ser uma string.',
            'password.min' => 'A senha do docente deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
            'data_nascimento.required' => 'A data de nascimento do docente é obrigatória.',
            'data_nascimento.date' => 'A data de nascimento do docente deve ser uma data válida.',
            'data_nascimento.before' => 'A data de nascimento do docente deve ser uma data anterior à hoje.',
            'especialidade.required' => 'A especialidade do docente é obrigatória.',
            'especialidade.string' => 'A especialidade do docente deve ser uma string.',
            'especialidade.max' => 'A especialidade do docente deve ter no máximo 255 caracteres.',
        ];
    }
}
