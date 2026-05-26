<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTurmaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $turma = $this->route('turma');
        return $this->user()->can('update', $turma);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome'       => 'sometimes|string|max:255',
            'curso_id'   => 'sometimes|integer|exists:cursos,id',
            'ano_letivo' => 'sometimes|integer|min:1900|max:' . (date('Y') + 1),
            'semestre'   => 'sometimes|integer|min:1|max:2',
            'capacidade' => 'nullable|integer|min:1',
            'turno'      => 'nullable|string|in:manhã,tarde,noite',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.string'         => 'O nome da turma deve ser uma string.',
            'nome.max'            => 'O nome da turma não pode exceder 255 caracteres.',
            'curso_id.exists'     => 'O curso seleccionado não existe.',
            'ano_letivo.integer'  => 'O ano lectivo deve ser um número inteiro.',
            'semestre.min'        => 'O semestre deve ser no mínimo 1.',
            'semestre.max'        => 'O semestre deve ser no máximo 2.',
            'turno.in'            => 'O turno deve ser: manhã, tarde ou noite.',
        ];
    }
}
