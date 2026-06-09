<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;


class StoreGradeRequest extends FormRequest
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
            'student_id'         => 'required|integer|exists:alunos,id',
            'subject_id'    => 'required|integer|exists:disciplinas,id',
            'class_id'         => 'required|integer|exists:turmas,id',
            'trimester_exam' => 'nullable|numeric|min:0|max:20',
            'semester_exam'  => 'nullable|numeric|min:0|max:20',
            'final_exam'      => 'nullable|numeric|min:0|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required'      => 'O aluno é obrigatório.',
            'student_id.exists'        => 'O aluno seleccionado não existe.',
            'subject_id.required' => 'A disciplina é obrigatória.',
            'subject_id.exists'   => 'A disciplina seleccionada não existe.',
            'class_id.required'      => 'A turma é obrigatória.',
            'class_id.exists'        => 'A turma seleccionada não existe.',
            '*.numeric'              => 'A nota deve ser um número.',
            '*.min'                  => 'A nota mínima é 0.',
            '*.max'                  => 'A nota máxima é 20.',
        ];
    }
}
