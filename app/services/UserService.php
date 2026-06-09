<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    public function __construct()
    {
        $this->model = User::class;
    }

    public function create(array $data): User
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
            'phone'    => $data['phone'] ?? null,
            'status'   => $data['status'] ?? 'active',
        ]);
    }

    public function update(int|User $id, array $data): User
    {
        $user = $id instanceof User
            ? $id
            : $this->findById($id);

        $user->update([
            'name'  => $data['name'] ?? $user->name,
            'email' => $data['email'] ?? $user->email,
            'phone' => $data['phone'] ?? $user->phone,
        ]);

        if (!empty($data['password'])) {
            $user->update([
                'password' => Hash::make($data['password']),
            ]);
        }

        return $user->fresh();
    }

    public function activate(User $user): bool
    {
        return $user->update(['status' => 'active']);
    }

    public function deactivate(User $user): bool
    {
        return $user->update(['status' => 'inactive']);
    }

    public function listFiltered(array $filters)
    {
        return User::query()
            ->filtered($filters)
            ->paginate(10);
    }
}
