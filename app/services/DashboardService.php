<?php

namespace App\Services\V1\Dashboard;

use App\Services\StudentService;
use App\Services\TeacherService;
use App\Services\CourseService;
use App\Services\SchoolClassService;

class AdminDashboardService
{
    public function __construct(
        protected StudentService $studentService,
        protected TeacherService $teacherService,
        protected CourseService $courseService,
        protected SchoolClassService $schoolClassService,
    ) {}

    public function getData(): array
    {
        return [
            'total_students' => $this->studentService->total(),
            'total_teachers' => $this->teacherService->total(),
            'total_courses'  => $this->courseService->total(),
            'total_classes'  => $this->schoolClassService->total(),

            'recent_students' => $this->studentService->recent(5),
            'recent_teachers' => $this->teacherService->recent(5),
            'recent_courses'  => $this->courseService->recent(5),
            'recent_classes'  => $this->schoolClassService->recent(5),
        ];
    }
}
