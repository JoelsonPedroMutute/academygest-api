<?php

namespace App\Services;

use App\Filters\SchoolClassFilter;
use App\Models\SchoolClass;

class SchoolClassService extends BaseService
{
    public function __construct(
        protected SchoolClassFilter $filter
    ) {
        $this->model = SchoolClass::class;
    }

    public function listFiltered(array $filters = [])
    {
        $query = SchoolClass::query()
            ->with([
                'course',
                'students',
                'subjects',
            ]);

        $this->filter->apply($query, $filters);

        return $query
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    public function create(array $data): SchoolClass
    {
        if (
            SchoolClass::where('name', $data['name'])->exists()
        ) {
            throw new \Exception(
                'A school class with this name already exists.'
            );
        }

        return parent::create($data);
    }

    public function update(string $id, array $data): SchoolClass
    {
        $schoolClass = $this->findById($id);

        if (isset($data['name'])) {
            if (
                SchoolClass::where('name', $data['name'])
                ->where('id', '!=', $id)
                ->exists()
            ) {
                throw new \Exception('A school class with this name already exists.');
            }
        }

        $schoolClass->update($data);

        return $schoolClass->fresh(['course', 'students', 'subjects']);
    }
    public function delete(string $id): void
    {
        $schoolClass = $this->findById($id);

        // opcional: verificar se tem alunos ou enrollments associados
        if ($schoolClass->students()->count() > 0) {
            throw new \Exception('Cannot delete a class with enrolled students.');
        }

        $schoolClass->delete();
    }
}
