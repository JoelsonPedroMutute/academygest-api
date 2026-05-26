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
            'aluno_id'       => 'required|integer|exists:alunos,id',
            'turma_id'       => 'required|integer|exists:turmas,id',
            'ano_letivo'     => 'nullable|string|max:10',
            'semestre'       => 'nullable|string|max:10',
            'data_matricula' => 'nullable|date',
            'status'         => 'nullable|in:ativa,suspensa,cancelada,concluida',
        ];
    }

    public function messages(): array
    {
        return [
            'aluno_id.required'  => 'O aluno é obrigatório.',
            'aluno_id.exists'    => 'O aluno seleccionado não existe.',
            'turma_id.required'  => 'A turma é obrigatória.',
            'turma_id.exists'    => 'A turma seleccionada não existe.',
            'data_matricula.date' => 'A data de matrícula deve ser uma data válida.',
            'status.in'          => 'O status deve ser: ativa, suspensa, cancelada ou concluida.',
        ];
    }
}
