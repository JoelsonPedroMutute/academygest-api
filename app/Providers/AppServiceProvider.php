<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\User;
use App\Policies\CoursePolicy;
use App\Policies\StudentPolicy;
use App\Policies\TeacherPolicy;
use App\Policies\SchoolClassPolicy;
use App\Policies\SubjectPolicy;
use App\Policies\EnrollmentPolicy;
use App\Policies\GradePolicy;
use App\Policies\UserPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Course::class, CoursePolicy::class);
        Gate::policy(Student::class, StudentPolicy::class);
        Gate::policy(Teacher::class, TeacherPolicy::class);
        Gate::policy(SchoolClass::class, SchoolClassPolicy::class);
        Gate::policy(Subject::class, SubjectPolicy::class);
        Gate::policy(Enrollment::class, EnrollmentPolicy::class);
        Gate::policy(Grade::class, GradePolicy::class);
        Gate::policy(User::class, UserPolicy::class);

        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return url('/api/auth/change-password?token=' . $token . '&email=' . urlencode($user->email));
        });
    }
}
