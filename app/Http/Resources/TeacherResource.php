<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'birth_date' => $this->birth_date,
            'specialty'  => $this->specialty,

            'user'     => UserResource::make($this->whenLoaded('user')),
            'subjects' => SubjectResource::collection($this->whenLoaded('subjects')),
        ];
    }
}
