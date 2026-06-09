<?php

namespace App\Services;

class AdminDashboardService
{
    public function __construct(
        protected StudentService      $studentService,
        protected TeacherService      $teacherService,
        protected CourseService       $courseService,
        protected SchoolClassService  $schoolClassService,
    ) {}

    public function getData(?string $role = null): array
    {
        $base = [
            'recent' => [
                'students'     => $this->studentService->recent(5),
                'teachers'     => $this->teacherService->recent(5),
                'schoolClasses' => $this->schoolClassService->recent(5),
            ],
        ];

        return match ($role) {

            'teacher' => array_merge($base, [
                'totals' => [
                    'schoolClasses' => $this->schoolClassService->total(),
                ],
            ]),

            'student' => array_merge($base, [
                'totals' => [
                    'courses' => $this->courseService->total(),
                ],
            ]),

            default => array_merge($base, [
                'totals' => [
                    'students'     => $this->studentService->total(),
                    'teachers'     => $this->teacherService->total(),
                    'courses'      => $this->courseService->total(),
                    'schoolClasses' => $this->schoolClassService->total(),
                ],
            ]),
        };
    }
}
