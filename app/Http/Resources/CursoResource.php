<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CursoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'duracao' => $this->duracao,

            'turmas' => TurmaResource::collection(
                $this->whenLoaded('turmas')
            ),
        ];
    }
}
