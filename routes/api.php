<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\EnrollmentController;
use App\Http\Controllers\Api\V1\GradeController;
use App\Http\Controllers\Api\V1\SchoolClassController;
use App\Http\Controllers\Api\V1\StudentController;
use App\Http\Controllers\Api\V1\SubjectController;
use App\Http\Controllers\Api\V1\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// PUBLIC ROUTES

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/change-password', [AuthController::class, 'resetPassword']);
    Route::get('/change-password', function (Request $request) {
        return response()->json([
            'message' => 'Use the token and email to reset your password via POST /api/auth/reset-password',
            'token'   => $request->query('token'),
            'email'   => $request->query('email'),
        ]);
    });

    // SELF-SERVICE REGISTRATION
    Route::post('/register/student', [AuthController::class, 'registerStudent']);
    Route::post('/register/teacher', [AuthController::class, 'registerTeacher']);
});

// PROTECTED ROUTES

Route::middleware(['auth:sanctum', 'active'])->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']);
    });

    // TEMPORARY TEST — remove after confirming it works
    Route::get('/ping', function (Request $request) {
        return response()->json([
            'user'     => $request->user(),
            'token_id' => $request->user()->currentAccessToken()->id,
        ]);
    });

    // ADMIN

    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [AdminDashboard::class, 'admin']);

            Route::get('teachers/pending', [TeacherController::class, 'pending']);
            Route::post('teachers/{teacher}/approve', [TeacherController::class, 'approve']);
            Route::post('teachers/{teacher}/reject', [TeacherController::class, 'reject']);

            Route::apiResource('students', StudentController::class);
            Route::apiResource('teachers', TeacherController::class);
            Route::apiResource('courses', CourseController::class);
            Route::apiResource('classes', SchoolClassController::class)->parameters([
                'classes' => 'schoolClass'
            ]);
            Route::apiResource('subjects', SubjectController::class);
            Route::apiResource('grades', GradeController::class);
            Route::apiResource('enrollments', EnrollmentController::class);
        });

    // TEACHER

    Route::middleware('role:teacher')
        ->prefix('teacher')
        ->name('teacher.')
        ->group(function () {

            Route::get('/dashboard', [AdminDashboard::class, 'teacher']);

            Route::get('grades', [GradeController::class, 'index']);
            Route::post('grades', [GradeController::class, 'store']);
            Route::get('grades/{grade}', [GradeController::class, 'show']);

            Route::get('classes', [SchoolClassController::class, 'index']);
            Route::get('classes/{schoolClass}', [SchoolClassController::class, 'show']);

            Route::get('courses', [CourseController::class, 'index']);
            Route::get('subjects', [SubjectController::class, 'index']);

            Route::get('profile', [TeacherController::class, 'myProfile']);
            Route::patch('profile', [TeacherController::class, 'updateMyProfile']);
        });

    // STUDENT

    Route::middleware('role:student')
        ->prefix('student')
        ->name('student.')
        ->group(function () {

            Route::get('/dashboard', [AdminDashboard::class, 'student']);

            Route::get('profile', [StudentController::class, 'myProfile']);
            Route::patch('profile', [StudentController::class, 'updateMyProfile']);

            Route::get('grades', [GradeController::class, 'myGrades']);

            Route::get('classes/{schoolClass}', [SchoolClassController::class, 'show']);

            Route::get('courses', [CourseController::class, 'index']);
            Route::get('subjects', [SubjectController::class, 'index']);
        });
});
