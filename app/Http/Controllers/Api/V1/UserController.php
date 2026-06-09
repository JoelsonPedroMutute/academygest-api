<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\IndexUserRequest;

use App\Http\Resources\UserResource;

use App\Models\User;
use App\Services\UserService;

class UserController extends BaseController
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function index(IndexUserRequest $request)
    {
        $this->authorize('viewAny', User::class);

        $users = $this->userService->listFiltered(
            $request->validated()
        );

        return UserResource::collection($users);
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        return new UserResource($user);
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        $user = $this->userService->create(
            $request->validated()
        );

        return new UserResource($user);
    }

    public function update(
        UpdateUserRequest $request,
        User $user
    ) {
        $this->authorize('update', $user);

        $user = $this->userService->update(
            $user->id,
            $request->validated()
        );

        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $this->userService->delete($user->id);

        return $this->success(
            'Utilizador eliminado com sucesso.'
        );
    }

    public function approveDocente(User $user)
    {
        $this->authorize('update', $user);

        $user->update([
            'status' => 'active'
        ]);

        return $this->success('Docente aprovado com sucesso.');
    }

    public function rejectDocente(User $user)
    {
        $this->authorize('update', $user);

        $user->update([
            'status' => 'rejected'
        ]);

        return $this->success('Docente rejeitado com sucesso.');
    }
}
