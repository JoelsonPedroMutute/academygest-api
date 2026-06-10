<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'workload'    => $this->workload,

            'course'         => CourseResource::make($this->whenLoaded('course')),
            'school_classes' => SchoolClassResource::collection($this->whenLoaded('classes')),
        ];
    }
}
