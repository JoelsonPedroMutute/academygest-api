<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Sala;

class StoreSalaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Sala::class);
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
            'name' => 'required|string|max:255|unique:salas',
            'capacidade' => 'required|integer|min:1',

        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'O nome da sala é obrigatório.',
            'name.string' => 'O nome da sala deve ser uma string.',
            'name.max' => 'O nome da sala deve ter no máximo 255 caracteres.',
            'name.unique' => 'Este nome de sala já está em uso.',
            'capacidade.required' => 'A capacidade da sala é obrigatória.',
            'capacidade.integer' => 'A capacidade da sala deve ser um número inteiro.',
            'capacidade.min' => 'A capacidade da sala deve ser pelo menos 1.',
        ];
    }
}
