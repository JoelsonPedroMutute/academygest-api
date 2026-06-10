<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $subject = $this->route('subject');
        return $this->user()->can('update', $subject);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $subject = $this->route('subject');

        return [
            'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id,
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'O nome da disciplina é obrigatório.',
            'name.string' => 'O nome da disciplina deve ser uma string.',
            'name.max' => 'O nome da disciplina deve ter no máximo 255 caracteres.',
            'name.unique' => 'Este nome de disciplina já está em uso.',
            'description.string' => 'A descrição da disciplina deve ser uma string.',
        ];
    }
}
