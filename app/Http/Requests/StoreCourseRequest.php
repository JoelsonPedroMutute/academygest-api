<?php

namespace App\Http\Requests;

use App\Models\Course;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Course::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:cursos',
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

        ];
    }
}
