<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGradeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $grade = $this->route('grade');
        return $this->user()->can('update', $grade);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_id'         => 'sometimes|integer|exists:students,id',
            'subject_id'    => 'sometimes|integer|exists:subjects,id',
            'class_id'         => 'sometimes|integer|exists:classes,id',
            'trimester_exam' => 'sometimes|nullable|numeric|min:0|max:20',
            'semester_exam'  => 'sometimes|nullable|numeric|min:0|max:20',
            'final_exam'      => 'sometimes|nullable|numeric|min:0|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.integer' => 'O ID do aluno deve ser um número inteiro.',
            'student_id.exists' => 'O aluno selecionado não existe.',
            'subject_id.integer' => 'O ID da disciplina deve ser um número inteiro.',
            'subject_id.exists' => 'A disciplina selecionada não existe.',
            'class_id.integer' => 'O ID da turma deve ser um número inteiro.',
            'class_id.exists' => 'A turma selecionada não existe.',
            'trimester_exam.numeric' => 'A nota do exame trimestral deve ser um número.',
            'trimester_exam.min' => 'A nota do exame trimestral deve ser no mínimo 0.',
            'trimester_exam.max' => 'A nota do exame trimestral deve ser no máximo 20.',
            'semester_exam.numeric' => 'A nota do exame semestral deve ser um número.',
            'semester_exam.min' => 'A nota do exame semestral deve ser no mínimo 0.',
            'semester_exam.max' => 'A nota do exame semestral deve ser no máximo 20.',
            'final_exam.numeric' => 'A nota do exame final deve ser um número.',
            'final_exam.min' => 'A nota do exame final deve ser no mínimo 0.',
            'final_exam.max' => 'A nota do exame final deve ser no máximo 20.',
        ];
    }
}
