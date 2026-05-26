<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNotaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $nota = $this->route('nota');
        return $this->user()->can('update', $nota);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'aluno_id'         => 'sometimes|integer|exists:alunos,id',
            'disciplina_id'    => 'sometimes|integer|exists:disciplinas,id',
            'turma_id'         => 'sometimes|integer|exists:turmas,id',
            'prova_trimestral' => 'sometimes|nullable|numeric|min:0|max:20',
            'prova_semestral'  => 'sometimes|nullable|numeric|min:0|max:20',
            'exame_final'      => 'sometimes|nullable|numeric|min:0|max:20',
        ];
    }
}
