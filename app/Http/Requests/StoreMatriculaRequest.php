<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Matricula;

class StoreMatriculaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Matricula::class);
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
            'aluno_id' => 'required|integer|exists:alunos,id',
            'turma_id' => 'required|integer|exists:turmas,id',
            'data_matricula' => 'required|date',

        ];
    }
    public function messages(): array
    {
        return [
            'aluno_id.required' => 'O aluno é obrigatório.',
            'aluno_id.integer' => 'O aluno deve ser um número inteiro.',
            'aluno_id.exists' => 'O aluno selecionado não existe.',
            'turma_id.required' => 'A turma é obrigatória.',
            'turma_id.integer' => 'A turma deve ser um número inteiro.',
            'turma_id.exists' => 'A turma selecionada não existe.',
            'data_matricula.required' => 'A data de matrícula é obrigatória.',
            'data_matricula.date' => 'A data de matrícula deve ser uma data válida.',
        ];
    }
}
