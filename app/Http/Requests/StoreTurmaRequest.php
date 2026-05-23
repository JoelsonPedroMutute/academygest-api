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
            'nome' => 'required|string|max:255',
            'ano' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'semestre' => 'required|integer|min:1|max:2',
        ];
    }
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome da turma é obrigatório.',
            'nome.string' => 'O nome da turma deve ser uma string.',
            'nome.max' => 'O nome da turma não pode exceder 255 caracteres.',
            'ano.required' => 'O ano da turma é obrigatório.',
            'ano.integer' => 'O ano da turma deve ser um número inteiro.',
            'ano.min' => 'O ano da turma não pode ser anterior a 1900.',
            'ano.max' => 'O ano da turma não pode ser posterior a ' . (date('Y') + 1) . '.',
            'semestre.required' => 'O semestre da turma é obrigatório.',
            'semestre.integer' => 'O semestre da turma deve ser um número inteiro.',
            'semestre.min' => 'O semestre da turma deve ser no mínimo 1.',
            'semestre.max' => 'O semestre da turma deve ser no máximo 2.',
        ];
    }
}
