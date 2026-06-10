<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GradeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'     => $this->id,
            'evaluations' => [
                'quarterly_exam' => $this->quarterly_exam,
                'semester_exam'  => $this->semester_exam,
                'final_exam'     => $this->final_exam,
            ],
            'final_average' => $this->final_average,
            'status'        => $this->status,

            'student'      => StudentResource::make($this->whenLoaded('student')),
            'subject'      => SubjectResource::make($this->whenLoaded('subject')),
            'school_class' => SchoolClassResource::make($this->whenLoaded('schoolClass')),
        ];
    }
}
