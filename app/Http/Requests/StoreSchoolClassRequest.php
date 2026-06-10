<?php

namespace App\Http\Requests;

use App\Models\SchoolClass;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolClassRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', SchoolClass::class);
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
            'name'       => 'required|string|max:255',
            'course_id'   => 'required|string|exists:courses,id',
            'academic_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'semester'   => 'required|integer|min:1|max:2',
            'capacity' => 'nullable|integer|min:1',
            'shift'      => 'nullable|string|in:morning,afternoon,night',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'       => 'O nome da turma é obrigatório.',
            'name.string'         => 'O nome da turma deve ser uma string.',
            'name.max'            => 'O nome da turma não pode exceder 255 caracteres.',
            'course_id.required'   => 'O curso é obrigatório.',
            'course_id.exists'     => 'O curso seleccionado não existe.',
            'academic_year.required' => 'O ano lectivo é obrigatório.',
            'academic_year.integer'  => 'O ano lectivo deve ser um número inteiro.',
            'academic_year.min'      => 'O ano lectivo não pode ser anterior a 1900.',
            'academic_year.max'      => 'O ano lectivo não pode ser posterior a ' . (date('Y') + 1) . '.',
            'semester.required'   => 'O semestre é obrigatório.',
            'semester.min'        => 'O semestre deve ser no mínimo 1.',
            'semester.max'        => 'O semestre deve ser no máximo 2.',
            'shift.in'            => 'O turno deve ser: manha, tarde ou noite.',
        ];
    }
}
