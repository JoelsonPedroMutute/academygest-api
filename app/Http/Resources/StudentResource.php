<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'birth_date'     => $this->birth_date,
            'student_number' => $this->student_number,

            'user'         => UserResource::make($this->whenLoaded('user')),
            'school_class' => SchoolClassResource::make($this->whenLoaded('schoolClass')),
            'enrollments'  => EnrollmentResource::collection($this->whenLoaded('enrollments')),
            'grades'       => GradeResource::collection($this->whenLoaded('grades')),
        ];
    }
}
