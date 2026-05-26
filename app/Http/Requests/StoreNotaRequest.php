<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Nota;

class StoreNotaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'aluno_id'         => 'required|integer|exists:alunos,id',
            'disciplina_id'    => 'required|integer|exists:disciplinas,id',
            'turma_id'         => 'required|integer|exists:turmas,id',
            'prova_trimestral' => 'nullable|numeric|min:0|max:20',
            'prova_semestral'  => 'nullable|numeric|min:0|max:20',
            'exame_final'      => 'nullable|numeric|min:0|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'aluno_id.required'      => 'O aluno é obrigatório.',
            'aluno_id.exists'        => 'O aluno seleccionado não existe.',
            'disciplina_id.required' => 'A disciplina é obrigatória.',
            'disciplina_id.exists'   => 'A disciplina seleccionada não existe.',
            'turma_id.required'      => 'A turma é obrigatória.',
            'turma_id.exists'        => 'A turma seleccionada não existe.',
            '*.numeric'              => 'A nota deve ser um número.',
            '*.min'                  => 'A nota mínima é 0.',
            '*.max'                  => 'A nota máxima é 20.',
        ];
    }
}
