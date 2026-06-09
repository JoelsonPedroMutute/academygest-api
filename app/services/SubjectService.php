<?php

namespace App\Services;

use App\Filters\SubjectFilter;
use App\Models\Subject;

class SubjectService extends BaseService
{
    public function __construct(
        protected SubjectFilter $filter
    ) {
        $this->model = Subject::class;
    }

    public function listFiltered(array $filters = [])
    {
        $query = Subject::query()
            ->with([
                'course',
                'teachers',
            ]);

        $this->filter->apply($query, $filters);

        return $query
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    public function create(array $data): Subject
    {
        if (Subject::where('name', $data['name'])->exists()) {
            throw new \Exception(
                'A subject with this name already exists.'
            );
        }

        return parent::create($data);
    }

   public function update(int $id, array $data): Subject
{
    $subject = $this->findById($id);

    if (
        Subject::where('name', $data['name'])
            ->where('id', '!=', $id)
            ->exists()
    ) {
        throw new \Exception(
            'A subject with this name already exists.'
        );
    }

    $subject->update($data);

    return $subject->fresh(['course', 'teachers']);
}
}