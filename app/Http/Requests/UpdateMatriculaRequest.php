<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMatriculaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $matricula = $this->route('matricula');
        return $this->user()->can('update', $matricula);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'aluno_id'       => 'sometimes|integer|exists:alunos,id',
            'turma_id'       => 'sometimes|integer|exists:turmas,id',
            'ano_letivo'     => 'sometimes|nullable|string|max:10',
            'semestre'       => 'sometimes|nullable|string|max:10',
            'data_matricula' => 'sometimes|nullable|date',
            'status'         => 'sometimes|in:ativa,suspensa,cancelada,concluida',
        ];
    }

    public function messages(): array
    {
        return [
            'aluno_id.exists'    => 'O aluno seleccionado não existe.',
            'turma_id.exists'    => 'A turma seleccionada não existe.',
            'data_matricula.date' => 'A data de matrícula deve ser uma data válida.',
            'status.in'          => 'O status deve ser: ativa, suspensa, cancelada ou concluida.',
        ];
    }
}
