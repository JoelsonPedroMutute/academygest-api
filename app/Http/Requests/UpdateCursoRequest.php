<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        $curso = $this->route('curso');
        return $this->user()->can('update', $curso);
    }

    public function rules(): array
    {
        $curso = $this->route('curso');

        return [
            'nome' => 'required|string|max:255|unique:cursos,nome,' . $curso->id,
            'duracao' => 'nullable|integer|min:1|max:10',
            'descricao' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do curso é obrigatório.',
            'nome.string' => 'O nome do curso deve ser uma string.',
            'nome.max' => 'O nome do curso deve ter no máximo 255 caracteres.',
            'nome.unique' => 'Este nome de curso já está em uso.',
            'descricao.string' => 'A descrição do curso deve ser uma string.',
            'duracao.integer' => 'A duração do curso deve ser um número inteiro.',
            'duracao.min' => 'A duração do curso deve ser no mínimo 1 ano.',
            'duracao.max' => 'A duração do curso deve ser no máximo 10 anos.',
        ];
    }
}
