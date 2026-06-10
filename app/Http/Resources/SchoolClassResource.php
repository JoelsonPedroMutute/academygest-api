<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolClassResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'academic_year' => $this->academic_year,
            'semester'      => $this->semester,
            'capacity'      => $this->capacity,
            'shift'         => $this->shift,

            'course'   => CourseResource::make($this->whenLoaded('course')),
            'subjects' => SubjectResource::collection($this->whenLoaded('subjects')),
        ];
    }
}
