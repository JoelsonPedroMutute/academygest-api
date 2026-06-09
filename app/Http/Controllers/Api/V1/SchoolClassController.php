<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\IndexSchoolClassRequest;
use App\Http\Requests\StoreSchoolClassRequest;
use App\Http\Requests\UpdateSchoolClassRequest;
use App\Http\Resources\SchoolClassResource;
use App\Models\SchoolClass;
use App\Services\SchoolClassService;

class SchoolClassController extends BaseController
{
    public function __construct(
        protected SchoolClassService $schoolClassService
    ) {}

    public function index(IndexSchoolClassRequest $request)
    {
        $this->authorize('viewAny', SchoolClass::class);

        $schoolClasses = $this->schoolClassService
            ->listFiltered($request->validated());

        return SchoolClassResource::collection($schoolClasses);
    }

    public function show(SchoolClass $schoolClass)
    {
        $this->authorize('view', $schoolClass);

        return new SchoolClassResource(
            $schoolClass->load(['course', 'students', 'subjects'])
        );
    }

    public function store(StoreSchoolClassRequest $request)
    {
        $this->authorize('create', SchoolClass::class);

        $data = $request->validated();

        if (isset($data['period']) && !isset($data['semester'])) {
            $data['semester'] = $data['period'];
        }

        $schoolClass = $this->schoolClassService->create($data);

        $schoolClass->load(['course', 'students', 'subjects']);

        return new SchoolClassResource($schoolClass);
    }

    public function update(UpdateSchoolClassRequest $request, SchoolClass $schoolClass)
    {
        $this->authorize('update', $schoolClass);

        $schoolClass = $this->schoolClassService->update(
            $schoolClass->id,
            $request->validated()
        );

        $schoolClass->load(['course', 'students', 'subjects']);

        return new SchoolClassResource($schoolClass);
    }

    public function destroy(SchoolClass $schoolClass)
    {
        $this->authorize('delete', $schoolClass);

        $this->schoolClassService->delete($schoolClass->id);

        return $this->success('School class deleted successfully.');
    }
}
