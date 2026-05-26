<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateDocenteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $docente = $this->route('docente');

        // Sem parâmetro = é o próprio docente atualizando o perfil
        if (!$docente) {
            return Auth::check() && Auth::user()->role === 'docente';
        }

        // Com parâmetro = admin atualizando docente específico
        return $this->user()->can('update', $docente);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'           => 'sometimes|string|max:255',
            'email'          => 'sometimes|email',
            'telefone'       => 'sometimes|nullable|string|max:20',
            'especialidade'  => 'sometimes|nullable|string|max:255',
            'data_nascimento' => 'sometimes|nullable|date',
        ];

        // Adicionar regras de unique apenas quando houver um docente específico
        $docente = $this->route('docente');
        if ($docente && $docente->user_id) {
            $userId = $docente->user_id;
            $rules['name'] .= '|unique:users,name,' . $userId;
            $rules['email'] .= '|unique:users,email,' . $userId;
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.string' => 'O nome do docente deve ser uma string.',
            'name.max' => 'O nome do docente deve ter no máximo 255 caracteres.',
            'name.unique' => 'Este nome de docente já está em uso.',
            'email.email' => 'O email do docente deve ser um endereço de email válido.',
            'email.unique' => 'Este email de docente já está em uso.',
            'telefone.string' => 'O telefone do docente deve ser uma string.',
            'telefone.max' => 'O telefone do docente deve ter no máximo 20 caracteres.',
            'especialidade.string' => 'A especialidade do docente deve ser uma string.',
            'especialidade.max' => 'A especialidade do docente deve ter no máximo 255 caracteres.',
        ];
    }
}
