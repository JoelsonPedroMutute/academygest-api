<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFrequenciaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $frequencia = $this->route('frequencia');
        return $this->user()->can('update', $frequencia);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $frequencia = $this->route('frequencia');
        return [
            'aluno_id' => 'required|integer|exists:alunos,id',
            'turma_id' => 'required|integer|exists:turmas,id',
            'data' => 'required|date',
            'presente' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'aluno_id.required' => 'O aluno é obrigatório.',
            'aluno_id.integer' => 'O aluno deve ser um número inteiro.',
            'aluno_id.exists' => 'O aluno selecionado não existe.',
            'turma_id.required' => 'A turma é obrigatória.',
            'turma_id.integer' => 'A turma deve ser um número inteiro.',
            'turma_id.exists' => 'A turma selecionada não existe.',
            'data.required' => 'A data é obrigatória.',
            'data.date' => 'A data deve ser uma data válida.',
            'presente.required' => 'O campo presente é obrigatório.',
            'presente.boolean' => 'O campo presente deve ser verdadeiro ou falso.',
        ];
    }
}
