<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        $course = $this->route('course');
        return $this->user()->can('update', $course);
    }

    public function rules(): array
    {
        $course = $this->route('course');

        return [
            'name' => 'required|string|max:255|unique:cursos,nome,' . $course->id,
            'duration' => 'nullable|integer|min:1|max:10',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do curso é obrigatório.',
            'name.string' => 'O nome do curso deve ser uma string.',
            'name.max' => 'O nome do curso deve ter no máximo 255 caracteres.',
            'name.unique' => 'Este nome de curso já está em uso.',
            'description.string' => 'A descrição do curso deve ser uma string.',
            'duration.integer' => 'A duração do curso deve ser um número inteiro.',
            'duration.min' => 'A duração do curso deve ser no mínimo 1 ano.',
            'duration.max' => 'A duração do curso deve ser no máximo 10 anos.',
        ];
    }
}
