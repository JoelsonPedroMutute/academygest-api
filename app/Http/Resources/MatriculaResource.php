<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatriculaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,

            'ano_letivo' => $this->ano_letivo,
            'semestre' => $this->semestre,
            'data_matricula' => $this->data_matricula,
            'status' => $this->status,

            'aluno' => AlunoResource::make(
                $this->whenLoaded('aluno')
            ),

            'turma' => TurmaResource::make(
                $this->whenLoaded('turma')
            ),
        ];
    }
}
