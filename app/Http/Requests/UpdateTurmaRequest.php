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
            'name' => 'required|string|max:255|unique:turmas,name,' . $this->route('turma')->id,
            'descricao' => 'nullable|string',

        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'O nome da turma é obrigatório.',
            'name.string' => 'O nome da turma deve ser uma string.',
            'name.max' => 'O nome da turma deve ter no máximo 255 caracteres.',
            'name.unique' => 'Este nome de turma já está em uso.',
            'descricao.string' => 'A descrição da turma deve ser uma string.',
        ];
    }
}
