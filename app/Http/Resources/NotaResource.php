<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            // ✅ correcto
            'avaliacoes' => [
                'prova_trimestral' => $this->prova_trimestral,
                'prova_semestral'  => $this->prova_semestral,
                'exame_final'      => $this->exame_final,
            ],

            'media_final' => $this->media_final,
            'situacao' => $this->situacao,

            'aluno' => AlunoResource::make($this->whenLoaded('aluno')),
            'disciplina' => DisciplinaResource::make($this->whenLoaded('disciplina')),
            'turma' => TurmaResource::make($this->whenLoaded('turma')),
        ];
    }
}
