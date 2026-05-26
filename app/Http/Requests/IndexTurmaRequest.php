<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexTurmaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', \App\Models\Turma::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search' => 'nullable|string|max:255',
            'curso_id' => 'nullable|integer|exists:cursos,id',
            'aluno_id' => 'nullable|integer|exists:alunos,id',
            'disciplina_id' => 'nullable|integer|exists:disciplinas,id',
        ];
    }
    public function messages(): array
    {
        return [
            'search.string' => 'O termo de busca deve ser uma string.',
            'search.max' => 'O termo de busca deve ter no máximo 255 caracteres.',
            'curso_id.integer' => 'O ID do curso deve ser um número inteiro.',
            'curso_id.exists' => 'O curso selecionado não existe.',
            'aluno_id.integer' => 'O ID do aluno deve ser um número inteiro.',
            'aluno_id.exists' => 'O aluno selecionado não existe.',
            'disciplina_id.integer' => 'O ID da disciplina deve ser um número inteiro.',
            'disciplina_id.exists' => 'A disciplina selecionada não existe.',
        ];
    }
}
