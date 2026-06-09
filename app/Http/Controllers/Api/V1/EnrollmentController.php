<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\IndexEnrollmentRequest;
use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Requests\UpdateEnrollmentRequest;
use App\Http\Resources\EnrollmentResource;
use App\Models\Enrollment;
use App\Services\EnrollmentService;

class EnrollmentController extends BaseController
{
    public function __construct(
        protected EnrollmentService $enrollmentService
    ) {}

    public function index(IndexEnrollmentRequest $request)
    {
        $this->authorize('viewAny', Enrollment::class);

        $enrollments = $this->enrollmentService
            ->listFiltered($request->validated());

        return $this->success(
            EnrollmentResource::collection($enrollments),
            'Enrollments listed successfully.'
        );
    }

    public function show(Enrollment $enrollment)
    {
        $this->authorize('view', $enrollment);

        $enrollment->load(['student', 'schoolClass']);

        return $this->success(
            new EnrollmentResource($enrollment),
            'Enrollment retrieved successfully.'
        );
    }

    public function store(StoreEnrollmentRequest $request)
    {
        $this->authorize('create', Enrollment::class);

        $enrollment = $this->enrollmentService
            ->create($request->validated());

        $enrollment->load(['student', 'schoolClass']);

        return $this->success(
            new EnrollmentResource($enrollment),
            'Enrollment created successfully.',
            201
        );
    }

    public function update(UpdateEnrollmentRequest $request, Enrollment $enrollment)
    {
        $this->authorize('update', $enrollment);

        $enrollment = $this->enrollmentService
            ->update($enrollment->id, $request->validated());

        return $this->success(
            new EnrollmentResource($enrollment),
            'Enrollment updated successfully.'
        );
    }

    public function destroy(Enrollment $enrollment)
    {
        $this->authorize('delete', $enrollment);

        $this->enrollmentService->delete($enrollment->id);

        return $this->success(null, 'Enrollment deleted successfully.');
    }
}
