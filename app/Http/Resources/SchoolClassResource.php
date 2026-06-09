<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolClassResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'academic_year' => $this->academic_year,
            'semester' => $this->semester,
            'capacity' => $this->capacity,
            'shift' => $this->shift,

            // relação com curso
            'course' => CourseResource::make(
                $this->whenLoaded('course')
            ),

            // relação many-to-many com disciplinas
            'subjects' => SubjectResource::collection(
                $this->whenLoaded('subjects')
            ),
        ];
    }
}
