<?php

namespace App\Services;

use App\Filters\TeacherFilter;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;

class TeacherService extends BaseService
{
    public function __construct(
        protected TeacherFilter $filter,
        protected UserService $userService
    ) {
        $this->model = Teacher::class;
    }

    public function listFiltered(array $filters = [])
    {
        $query = Teacher::query()
            ->with(['user']);

        $this->filter->apply($query, $filters);

        return $query->latest()->paginate(10)->withQueryString();
    }

    public function create(array $data, string $context = 'public'): Teacher
    {
        return DB::transaction(function () use ($data, $context) {

            $isAdmin = $context === 'admin';

            $user = $this->userService->create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => $data['password'],
                'role'     => 'teacher',
                'phone'    => $data['phone'] ?? null,
                'status'   => $isAdmin ? 'active' : 'pending',
            ]);

            return Teacher::create([
                'user_id'    => $user->id,
                'birth_date' => $data['birth_date'],
                'specialty'  => $data['specialty'],
                'phone'      => $data['phone'] ?? null,
                'status'     => $isAdmin ? 'active' : 'pending',
            ])->load([
                'user',
            ]);
        });
    }

    public function update(string $id, array $data): Teacher
    {
        return DB::transaction(function () use ($id, $data) {

            $teacher = $this->findById($id);

            $this->userService->update($teacher->user, $data);

            $teacher->update(array_filter([
                'birth_date' => $data['birth_date'] ?? null,
                'specialty'  => $data['specialty'] ?? null,
                'phone'      => $data['phone'] ?? null,
            ], fn($value) => $value !== null));

            return $teacher->fresh(['user']);
        });
    }

    public function findByUser(string $userId): Teacher
    {
        return Teacher::with(['user'])
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    public function listPending()
    {
        return Teacher::query()
            ->whereHas('user', function ($query) {
                $query->where('status', 'pending');
            })
            ->with(['user'])
            ->latest()
            ->paginate();
    }

    public function approve(Teacher $teacher): Teacher
    {
        $teacher->user->update([
            'status' => 'active',
        ]);

        return $teacher->fresh(['user']);
    }

    public function reject(Teacher $teacher): Teacher
    {
        $teacher->user->update([
            'status' => 'rejected',
        ]);

        return $teacher->fresh(['user']);
    }
    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            $teacher = $this->findById($id);
            $teacher->user()->delete();
            $teacher->delete();
        });
    }
}
