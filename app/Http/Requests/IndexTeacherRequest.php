<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexTeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', \App\Models\Teacher::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',

        ];
    }
    public function messages(): array
    {
        return [
            'search.string' => 'O termo de busca deve ser uma string.',
            'search.max' => 'O termo de busca deve ter no máximo 255 caracteres.',
            'user_id.integer' => 'O ID do usuário deve ser um número inteiro.',
            'user_id.exists' => 'O usuário selecionado não existe.',

        ];
    }
}
