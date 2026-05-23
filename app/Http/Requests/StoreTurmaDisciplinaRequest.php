<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\TurmaDisciplina;

class StoreTurmaDisciplinaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', TurmaDisciplina::class);
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
            'disciplina_id' => 'required|integer|exists:disciplinas,id',

        ];
    }
    public function messages(): array
    {
        return [
            'turma_id.required' => 'A turma é obrigatória.',
            'turma_id.integer' => 'A turma deve ser um número inteiro.',
            'turma_id.exists' => 'A turma selecionada não existe.',
            'disciplina_id.required' => 'A disciplina é obrigatória.',
            'disciplina_id.integer' => 'A disciplina deve ser um número inteiro.',
            'disciplina_id.exists' => 'A disciplina selecionada não existe.',
        ];
    }
}
