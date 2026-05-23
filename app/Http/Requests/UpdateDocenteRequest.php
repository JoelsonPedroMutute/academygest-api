<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDocenteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $docente = $this->route('docente');
        return $this->user()->can('update', $docente);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:docentes,name,' . $this->route('docente')->id,
            'email' => 'required|email|unique:docentes,email,' . $this->route('docente')->id,
            'telefone' => 'nullable|string|max:20',
            'especialidade' => 'nullable|string|max:255',

        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'O nome do docente é obrigatório.',
            'name.string' => 'O nome do docente deve ser uma string.',
            'name.max' => 'O nome do docente deve ter no máximo 255 caracteres.',
            'name.unique' => 'Este nome de docente já está em uso.',
            'email.required' => 'O email do docente é obrigatório.',
            'email.email' => 'O email do docente deve ser um endereço de email válido.',
            'email.unique' => 'Este email de docente já está em uso.',
            'telefone.string' => 'O telefone do docente deve ser uma string.',
            'telefone.max' => 'O telefone do docente deve ter no máximo 20 caracteres.',
            'especialidade.string' => 'A especialidade do docente deve ser uma string.',
            'especialidade.max' => 'A especialidade do docente deve ter no máximo 255 caracteres.',
        ];
    }
}
