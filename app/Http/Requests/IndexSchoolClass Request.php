<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexSchoolClassRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', \App\Models\SchoolClass::class);
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
            'student_id' => 'nullable|integer|exists:alunos,id',
            'class_id' => 'nullable|integer|exists:turmas,id',
            'course_id' => 'nullable|integer|exists:cursos,id',
        ];
    }

    public function messages(): array
    {
        return [
            'search.string' => 'O termo de busca deve ser uma string.',
            'search.max' => 'O termo de busca deve ter no máximo 255 caracteres.',
            'student_id.integer' => 'O ID do aluno deve ser um número inteiro.',
            'student_id.exists' => 'O aluno selecionado não existe.',
            'class_id.integer' => 'O ID da turma deve ser um número inteiro.',
            'class_id.exists' => 'A turma selecionada não existe.',
            'course_id.integer' => 'O ID do curso deve ser um número inteiro.',
            'course_id.exists' => 'O curso selecionado não existe.',
        ];
    }
}
