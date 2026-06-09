<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->nome,
            'description' => $this->descricao,
            'duration' => $this->duracao,

            'classes' => SchoolClassResource::collection(
                $this->whenLoaded('schoolClasses')
            ),
        ];
    }
}
