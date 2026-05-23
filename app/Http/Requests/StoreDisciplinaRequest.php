<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Disciplina;

class StoreDisciplinaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Disciplina::class);
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
            'name' => 'required|string|max:255|unique:disciplinas',
            'descricao' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome da disciplina é obrigatório.',
            'name.string' => 'O nome da disciplina deve ser uma string.',
            'name.max' => 'O nome da disciplina deve ter no máximo 255 caracteres.',
            'name.unique' => 'Este nome de disciplina já está em uso.',
            'descricao.string' => 'A descrição da disciplina deve ser uma string.',
        ];
    }
}
