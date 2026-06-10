<?php

namespace App\Services;

use App\Filters\EnrollmentFilter;
use App\Models\Enrollment;

class EnrollmentService extends BaseService
{
    public function __construct(
        protected EnrollmentFilter $filter
    ) {
        $this->model = Enrollment::class;
    }

    public function listFiltered(array $filters = [])
    {
        $query = Enrollment::query()
            ->with(['student', 'schoolClass']);

        $this->filter->apply($query, $filters);

        return $query->latest()->paginate(10)->withQueryString();
    }
}
