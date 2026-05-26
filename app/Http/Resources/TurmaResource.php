<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TurmaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'ano_letivo' => $this->ano_letivo,
            'semestre' => $this->semestre,
            'capacidade' => $this->capacidade,
            'turno' => $this->turno,

            // relação com curso
            'curso' => CursoResource::make(
                $this->whenLoaded('curso')
            ),

            // relação many-to-many com disciplinas
            'disciplinas' => DisciplinaResource::collection(
                $this->whenLoaded('disciplinas')
            ),
        ];
    }
}
