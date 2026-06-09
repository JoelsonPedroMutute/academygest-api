<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,

            'user' => UserResource::make(
                $this->whenLoaded('user')
            ),

            'birth_date' => $this->birth_date,

            'enrollments' => EnrollmentResource::collection(
                $this->whenLoaded('enrollments')
            ),

            'grades' => GradeResource::collection(
                $this->whenLoaded('grades')
            ),

            'school_class' => SchoolClassResource::make(
                $this->whenLoaded('schoolClass')
            ),
        ];
    }
}