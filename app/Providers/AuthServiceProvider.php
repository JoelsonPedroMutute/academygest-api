<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models\Course;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\SchoolClass;

use App\Policies\CoursePolicy;
use App\Policies\StudentPolicy;
use App\Policies\SubjectPolicy;
use App\Policies\TeacherPolicy;
use App\Policies\EnrollmentPolicy;
use App\Policies\GradePolicy;
use App\Policies\SchoolClassPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Course::class      => CoursePolicy::class,
        Student::class     => StudentPolicy::class,
        Subject::class     => SubjectPolicy::class,
        Teacher::class     => TeacherPolicy::class,
        Enrollment::class  => EnrollmentPolicy::class,
        Grade::class       => GradePolicy::class,
        SchoolClass::class => SchoolClassPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
