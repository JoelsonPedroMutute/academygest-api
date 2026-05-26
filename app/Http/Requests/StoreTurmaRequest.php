<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Turma;

class StoreTurmaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Turma::class);
        // return false; --- IGNORE ---
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome'       => 'required|string|max:255',
            'curso_id'   => 'required|integer|exists:cursos,id',
            'ano_letivo' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'semestre'   => 'required|integer|min:1|max:2',
            'capacidade' => 'nullable|integer|min:1',
            'turno'      => 'nullable|string|in:manha,tarde,noite',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required'       => 'O nome da turma é obrigatório.',
            'nome.string'         => 'O nome da turma deve ser uma string.',
            'nome.max'            => 'O nome da turma não pode exceder 255 caracteres.',
            'curso_id.required'   => 'O curso é obrigatório.',
            'curso_id.exists'     => 'O curso seleccionado não existe.',
            'ano_letivo.required' => 'O ano lectivo é obrigatório.',
            'ano_letivo.integer'  => 'O ano lectivo deve ser um número inteiro.',
            'ano_letivo.min'      => 'O ano lectivo não pode ser anterior a 1900.',
            'ano_letivo.max'      => 'O ano lectivo não pode ser posterior a ' . (date('Y') + 1) . '.',
            'semestre.required'   => 'O semestre é obrigatório.',
            'semestre.min'        => 'O semestre deve ser no mínimo 1.',
            'semestre.max'        => 'O semestre deve ser no máximo 2.',
            'turno.in'            => 'O turno deve ser: manha, tarde ou noite.',
        ];
    }
}
