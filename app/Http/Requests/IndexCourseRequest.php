<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', \App\Models\Course::class);
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
            'discipline_id' => 'nullable|integer|exists:disciplinas,id',
            'class_id' => 'nullable|integer|exists:school_classes,id',
        ];
    }

    public function messages(): array
    {
        return [
            'search.string' => 'O termo de busca deve ser uma string.',
            'search.max' => 'O termo de busca deve ter no máximo 255 caracteres.',
            'discipline_id.integer' => 'O ID da disciplina deve ser um número inteiro.',
            'discipline_id.exists' => 'A disciplina selecionada não existe.',
            'class_id.integer' => 'O ID da turma deve ser um número inteiro.',
            'class_id.exists' => 'A turma selecionada não existe.',
        ];
    }
}
