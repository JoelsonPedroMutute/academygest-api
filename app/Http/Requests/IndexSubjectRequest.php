<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexSubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', \App\Models\Subject::class);
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
            'course_id' => 'nullable|integer|exists:cursos,id',
            'teacher_id' => 'nullable|integer|exists:turmas,id',
        ];
    }
    public function messages(): array
    {
        return [
            'search.string' => 'O termo de busca deve ser uma string.',
            'search.max' => 'O termo de busca deve ter no máximo 255 caracteres.',
            'course_id.integer' => 'O ID do curso deve ser um número inteiro.',
            'course_id.exists' => 'O curso selecionado não existe.',
            'teacher_id.integer' => 'O ID do docente deve ser um número inteiro.',
            'teacher_id.exists' => 'O docente selecionado não existe.',
        ];
    }
}
