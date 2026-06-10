<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\IndexCourseRequest;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Services\CourseService;

class CourseController extends BaseController
{
    public function __construct(
        protected CourseService $courseService
    ) {}

    public function index(IndexCourseRequest $request)
    {
        $this->authorize('viewAny', Course::class);

        $courses = $this->courseService->listarFiltrado(
            $request->validated()
        );

        return CourseResource::collection($courses);
    }

    public function show(Course $course)
    {
        $this->authorize('view', $course);

        $course->load(['subjects', 'classes']);

        return new CourseResource($course);
    }

    public function store(StoreCourseRequest $request)
    {
        $this->authorize('create', Course::class);

        $course = $this->courseService->create(
            $request->validated()
        );

        $course->load(['subjects', 'classes']);

        return new CourseResource($course);
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $this->authorize('update', $course);

        $course = $this->courseService->update(
            $course->id,
            $request->validated()
        );

        $course->load(['subjects', 'classes']);

        return new CourseResource($course);
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        $this->courseService->delete($course->id);

        return $this->success(null, 'Course deleted successfully.');
    }
}
