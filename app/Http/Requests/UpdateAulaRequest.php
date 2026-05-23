<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAulaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $aula = $this->route('aula');
        return $this->user()->can('update', $aula);
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
            'data' => 'required|date',
            'horario_inicio' => 'required|date_format:H:i',
            'horario_fim' => 'required|date_format:H:i|after:horario_inicio',
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
            'data.required' => 'A data é obrigatória.',
            'data.date' => 'A data deve ser uma data válida.',
            'horario_inicio.required' => 'O horário de início é obrigatório.',
            'horario_inicio.date_format' => 'O horário de início deve estar no formato HH:mm.',
            'horario_fim.required' => 'O horário de fim é obrigatório.',
            'horario_fim.date_format' => 'O horário de fim deve estar no formato HH:mm.',
            'horario_fim.after' => 'O horário de fim deve ser posterior ao horário de início.',
        ];
    }
}
