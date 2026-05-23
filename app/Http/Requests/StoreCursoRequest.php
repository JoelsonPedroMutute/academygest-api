<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Curso;

class StoreCursoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Curso::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255|unique:cursos',
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

        ];
    }
}
