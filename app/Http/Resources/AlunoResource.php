<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlunoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,

            'user' => UserResource::make(
                $this->whenLoaded('user')
            ),

            'data_nascimento' => $this->data_nascimento,

            'matriculas' => MatriculaResource::collection(
                $this->whenLoaded('matriculas')
            ),

            'notas' => NotaResource::collection(
                $this->whenLoaded('notas')
            ),
            'turma' => TurmaResource::make(
                $this->whenLoaded('turma')
            ),
        ];
    }
}
