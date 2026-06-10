<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'duration'    => $this->duration,

            'classes' => SchoolClassResource::collection(
                $this->whenLoaded('classes')
            ),
        ];
    }
}
