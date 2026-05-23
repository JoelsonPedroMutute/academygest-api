<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Aluno;


class StoreAlunoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Aluno::class);
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
            'password' => 'required|string|min:6|confirmed',
            'turma_id' => 'required|integer|exists:turmas,id',
            'data_nascimento' => 'required|date|before:today',
            'numero_estudante' => 'required|string|max:20|unique:alunos',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email deve ser um endereço de email válido.',
            'email.unique' => 'Este email já está em uso.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'turma_id.required' => 'A turma é obrigatória.',
            'turma_id.integer' => 'A turma deve ser um número inteiro.',
            'turma_id.exists' => 'A turma selecionada não existe.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.date' => 'A data de nascimento deve ser uma data válida.',
            'data_nascimento.before' => 'A data de nascimento deve ser anterior a hoje.',
            'numero_estudante.required' => 'O número de estudante é obrigatório.',
            'numero_estudante.string' => 'O número de estudante deve ser uma string.',
            'numero_estudante.max' => 'O número de estudante deve ter no máximo 20 caracteres.',
            'numero_estudante.unique' => 'Este número de estudante já está em uso.',
        ];
    }
}
