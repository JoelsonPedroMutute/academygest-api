<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTurmaDisciplinaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $turmaDisciplina = $this->route('turma_disciplina');
        return $this->user()->can('update', $turmaDisciplina);
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
            'turma_id.exists' => 'A turma selecionada não existe.',
            'disciplina_id.exists' => 'A disciplina selecionada não existe.',
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
