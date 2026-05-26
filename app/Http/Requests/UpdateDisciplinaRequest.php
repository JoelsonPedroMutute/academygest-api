<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDisciplinaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $disciplina = $this->route('disciplina');
        return $this->user()->can('update', $disciplina);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255|unique:disciplinas,nome,' . $this->route('disciplina')->id,
            'descricao' => 'nullable|string',

        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome da disciplina é obrigatório.',
            'nome.string' => 'O nome da disciplina deve ser uma string.',
            'nome.max' => 'O nome da disciplina deve ter no máximo 255 caracteres.',
            'nome.unique' => 'Este nome de disciplina já está em uso.',
            'descricao.string' => 'A descrição da disciplina deve ser uma string.',
        ];
    }
}
