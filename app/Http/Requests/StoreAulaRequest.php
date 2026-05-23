<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Aula;

class StoreAulaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Aula::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'turma_id' => 'required|integer|exists:turmas,id',
            'data' => 'required|date',
            'presente' => 'required|boolean',
            'professor_id' => 'required|integer|exists:users,id',

        ];
    }
    public function messages(): array
    {
        return [
            'turma_id.required' => 'A turma é obrigatória.',
            'turma_id.integer' => 'A turma deve ser um número inteiro.',
            'turma_id.exists' => 'A turma selecionada não existe.',
            'data.required' => 'A data é obrigatória.',
            'data.date' => 'A data deve ser uma data válida.',
            'presente.required' => 'O campo presente é obrigatório.',
            'presente.boolean' => 'O campo presente deve ser verdadeiro ou falso.',
            'professor_id.required' => 'O professor é obrigatório.',
            'professor_id.integer' => 'O professor deve ser um número inteiro.',
            'professor_id.exists' => 'O professor selecionado não existe.',
        ];
    }
}
