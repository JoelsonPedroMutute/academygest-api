<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'              => $this->id,
            'academic_year'   => $this->academic_year,
            'semester'        => $this->semester,
            'enrollment_date' => $this->enrollment_date,
            'status'          => $this->status,

            'student'      => StudentResource::make($this->whenLoaded('student')),
            'school_class' => SchoolClassResource::make($this->whenLoaded('schoolClass')),
        ];
    }
}
