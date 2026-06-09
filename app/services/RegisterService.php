<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RegisterService
{
    public function __construct(
        private UserService $userService,
        private TeacherService $teacherService
    ) {}

    public function registerTeacher(array $data): array
    {
        return DB::transaction(function () use ($data) {

            $user = $this->userService->create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => $data['password'],
                'role'     => 'teacher',
                'phone'    => $data['phone'] ?? null,
                'status'   => 'pending',
            ]);

            $teacher = $this->teacherService->create(
                $data,
                'public'
            );

            return [
                'user' => $user,
                'teacher' => $teacher,
                'message' => 'Registo enviado.'
            ];
        });
    }
}
