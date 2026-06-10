<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Services\StudentService;
use App\Services\TeacherService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class AuthController extends BaseController
{
    public function __construct(
        private AuthService $authService,
        private TeacherService $teacherService,
        private StudentService $studentService
    ) {}

    public function login(Request $request)
    {
        $data = $this->authService->login(
            $request->only('email', 'password')
        );

        if (!$data['success']) {
            return $this->error($data['message'], 401);
        }

        return $this->success([
            'user'  => new UserResource($data['user']),
            'token' => $data['token'],
        ], 'Login successful.');
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return $this->success(null, 'Logged out successfully.');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $data = $this->authService->forgotPassword(
            $request->only('email')
        );

        if (!$data['success']) {
            return $this->error($data['message'], 400);
        }

        return $this->success(null, $data['message']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = $this->authService->resetPassword(
            $request->only('email', 'password', 'password_confirmation', 'token')
        );

        if (!$data['success']) {
            return $this->error($data['message'], 400);
        }

        return $this->success(null, $data['message']);
    }

    public function registerTeacher(StoreTeacherRequest $request)
    {
        $teacher = $this->teacherService->create(
            $request->validated(),
            'public'
        );

        return $this->success($teacher, 'Registration submitted. Awaiting approval.', 201);
    }

    public function registerStudent(StoreStudentRequest $request)
    {
        $student = $this->studentService->create(
            $request->validated(),
            'public'
        );

        return $this->success($student, 'Student registered successfully.', 201);
    }

    public function profile(Request $request)
    {
        return $this->success(new UserResource($request->user()), 'Profile loaded successfully.');
    }
}
