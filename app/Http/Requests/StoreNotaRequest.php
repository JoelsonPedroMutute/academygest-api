<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Nota;

class StoreNotaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Nota::class);
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
            'nota.min' => 'A nota deve ser um valor entre 0 e 10.',
            'nota.max' => 'A nota deve ser um valor entre 0 e 10.',
            'data.required' => 'A data é obrigatória.',
            'data.date' => 'A data deve ser uma data válida.',
        ];
    }
}
