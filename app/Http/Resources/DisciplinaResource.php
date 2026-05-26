<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class DisciplinaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'carga_horaria' => $this->carga_horaria,

            'curso' => CursoResource::make(
                $this->whenLoaded('curso')
            ),

            'turmas' => TurmaResource::collection(
                $this->whenLoaded('turmas')
            ),
        ];
    }
}
