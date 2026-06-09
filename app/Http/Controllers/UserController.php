<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        $data = $request->validated();


        if (
            $data['role'] === 'admin' &&
            Auth()->Auth::user()->role !== 'admin'
        ) {
            return $this->error('Acesso negado.', 403);
        }

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
        ]);


        $this->createProfile($user);

        return new UserResource($user);
    }


    private function createProfile(User $user): void
    {
        match ($user->role) {
            'student' => Student::create([
                'user_uuid' => $user->id,
            ]),

            'teacher' => Teacher::create([
                'user_uuid' => $user->id,
            ]),

            default => null,
        };
    }
}
