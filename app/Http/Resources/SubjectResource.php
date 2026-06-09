<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->n,
            'description' => $this->descricao,
            'hourly_load' => $this->carga_horaria,

            'course' => CourseResource::make(
                $this->whenLoaded('curso')
            ),

            'school_classes' => SchoolClassResource::collection(
                $this->whenLoaded('schoolClasses')
            ),
        ];
    }
}
