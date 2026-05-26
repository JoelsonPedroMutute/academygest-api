<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexAlunoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', \App\Models\Aluno::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'serch' => 'nullable|string|max:255',
            'aluno_id' => 'nullable|integer|exists:alunos,id',
            'turma_id' => 'nullable|integer|exists:turmas,id',
        ];
    }

    public function messages(): array
    {
        return [
            'search.string' => 'O termo de busca deve ser uma string.',
            'search.max' => 'O termo de busca deve ter no máximo 255 caracteres.',
            'aluno_id.integer' => 'O ID do aluno deve ser um número inteiro.',
            'aluno_id.exists' => 'O aluno selecionado não existe.',
            'turma_id.integer' => 'O ID da turma deve ser um número inteiro.',
            'turma_id.exists' => 'A turma selecionada não existe.',
        ];
    }
}
