<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNotaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
       $nota = $this->route('nota');
       return $this->user()->can('update', $nota);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'aluno_id' => 'required|integer|exists:alunos,id',
            'disciplina_id' => 'required|integer|exists:disciplinas,id',
            'nota' => 'required|numeric|min:0|max:20',
            'data' => 'required|date',
        ];
    }
    public function messages(): array
    {
        return [
            'aluno_id.required' => 'O aluno é obrigatório.',
            'aluno_id.integer' => 'O aluno deve ser um número inteiro.',
            'aluno_id.exists' => 'O aluno selecionado não existe.',
            'disciplina_id.required' => 'A disciplina é obrigatória.',
            'disciplina_id.integer' => 'A disciplina deve ser um número inteiro.',
            'disciplina_id.exists' => 'A disciplina selecionada não existe.',
            'nota.required' => 'A nota é obrigatória.',
            'nota.numeric' => 'A nota deve ser um número.',
            'nota.min' => 'A nota deve ser no mínimo 0.',
            'nota.max' => 'A nota deve ser no máximo 20.',
            'data.required' => 'A data é obrigatória.',
            'data.date' => 'A data deve ser uma data válida.',
        ];
    }
}
