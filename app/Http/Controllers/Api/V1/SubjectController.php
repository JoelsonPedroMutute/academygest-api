<?php

namespace App\Http\Controllers\Api\V1;



use App\Http\Requests\IndexSubjectRequest;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use App\Services\SubjectService;

class SubjectController extends BaseController
{
    public function __construct(
        protected SubjectService $subjectService
    ) {}

    public function index(IndexSubjectRequest $request)
    {
        $this->authorize('viewAny', Subject::class);

        $subjects = $this->subjectService->listFiltered(
            $request->validated()
        );

        return SubjectResource::collection($subjects);
    }


    public function show(Subject $subject)
    {
        $this->authorize('view', $subject);

        $subject->load([
            'course',
            'teachers',
        ]);

        return new SubjectResource($subject);
    }


    public function store(StoreSubjectRequest $request)
    {
        $this->authorize('create', Subject::class);

        $subject = $this->subjectService->create(
            $request->validated()
        );

        $subject->load([
            'course',
            'teachers',
        ]);

        return new SubjectResource($subject);
    }

    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $this->authorize('update', $subject);

        $subject = $this->subjectService->update(
            $subject->id,
            $request->validated()
        );

        $subject->load([
            'course',
            'teachers',
        ]);

        return new SubjectResource($subject);
    }

    public function destroy(Subject $subject)
    {
        $this->authorize('delete', $subject);

        $this->subjectService->delete($subject->id);

        return $this->success(
            'Subject eliminada com sucesso.'
        );
    }
}
