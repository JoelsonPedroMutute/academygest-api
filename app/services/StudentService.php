<?php

namespace App\Services;

use App\Filters\StudentFilter;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentService extends BaseService
{
    public function __construct(
        protected StudentFilter $filter,
        protected UserService $userService
    ) {
        $this->model = Student::class;
    }

    public function listFiltered(array $filters = [])
    {
        $query = Student::query()->with(['user', 'schoolClass']);

        $this->filter->apply($query, $filters);

        return $query->latest()->paginate(10)->withQueryString();
    }

    public function listTrashed()
    {
        return Student::onlyTrashed()
            ->with(['user', 'schoolClass'])
            ->latest()
            ->paginate(10);
    }

    public function create(array $data, string $context = 'public'): Student
    {
        return DB::transaction(function () use ($data, $context) {

            $user = $this->userService->create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => $data['password'],
                'role'     => 'student',
                'status'   => 'active',
            ]);

            // Auto-generate student number
            $studentNumber = 'STU' . date('Y') . str_pad($user->id, 4, '0', STR_PAD_LEFT);

            return Student::create([
                'user_id'        => $user->id,
                'birth_date'     => $data['birth_date'],
                'student_number' => $studentNumber,
                'class_id'       => $data['class_id'],
            ]);
        });
    }

    public function update(int $id, array $data): Student
    {
        $student = $this->findById($id);

        $this->userService->update($student->user, $data);

        $student->update(array_filter([
            'birth_date' => $data['birth_date'] ?? null,
            'class_id'   => $data['class_id'] ?? null,
        ]));

        return $student->fresh(['user', 'schoolClass']);
    }

   public function delete(int $id): void
{
    $student = $this->findById($id);

    $student->user->delete();
    $student->delete();
}

    public function restore(string $id): bool
    {
        $student = Student::onlyTrashed()->findOrFail($id);

        return DB::transaction(function () use ($student) {
            $student->restore();
            $student->user()->withTrashed()->restore();

            return true;
        });
    }

    public function activate(string $id): bool
    {
        $student = $this->findById($id);

        return $this->userService->activate($student->user);
    }

    public function deactivate(string $id): bool
    {
        $student = $this->findById($id);

        return $this->userService->deactivate($student->user);
    }

    public function findByUser(string $userId): Student
    {
        return Student::with(['user', 'schoolClass'])
            ->where('user_id', $userId)
            ->firstOrFail();
    }
}
