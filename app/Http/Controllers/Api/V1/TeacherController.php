<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\IndexTeacherRequest;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use App\Services\TeacherService;
use Illuminate\Support\Facades\Auth;

class TeacherController extends BaseController
{
    public function __construct(
        protected TeacherService $teacherService
    ) {}


    public function index(IndexTeacherRequest $request)
    {
        $this->authorize('viewAny', Teacher::class);

        $teachers = $this->teacherService->listFiltered(
            $request->validated()
        );

        return $this->success(
            TeacherResource::collection($teachers),
            'Docentes listados com sucesso.'
        );
    }

    public function show(Teacher $teacher)
    {
        $this->authorize('view', $teacher);

        $teacher->load(['user']);

        return $this->success(
            new TeacherResource($teacher),
            'Docente encontrado com sucesso.'
        );
    }

    public function store(StoreTeacherRequest $request)
    {
        $this->authorize('create', Teacher::class);

        $teacher = $this->teacherService->create(
            $request->validated(),
            'admin'
        );

        return $this->success(
            new TeacherResource($teacher),
            'Docente criado com sucesso.',
            201
        );
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $this->authorize('update', $teacher);

        $teacher = $this->teacherService->update(
            $teacher->id,
            $request->validated()
        );

        $teacher->load(['user']);

        return $this->success(
            new TeacherResource($teacher),
            'Docente actualizado com sucesso.'
        );
    }

    public function meuPerfil()
    {
        $teacher = $this->teacherService->findByUser(Auth::id());

        abort_if(!$teacher, 404);

        $teacher->load(['user']);

        return $this->success(
            new TeacherResource($teacher),
            'Perfil carregado com sucesso.'
        );
    }
    public function actualizarMeuPerfil(UpdateTeacherRequest $request)
    {
        $teacher = $this->teacherService->findByUser(Auth::id());
        abort_if(!$teacher, 404);


        $teacher = $this->teacherService->update(
            $teacher->id,
            $request->validated()
        );

        $teacher->load(['user']);

        return $this->success(
            new TeacherResource($teacher),
            'Perfil actualizado com sucesso.'
        );
    }


    public function approve(Teacher $teacher)
    {
        $this->authorize('update', $teacher);

        $teacher->user->update([
            'status' => 'approved'
        ]);

        $teacher->load('user');

        return $this->success(
            new TeacherResource($teacher),
            'Docente aprovado com sucesso.'
        );
    }

    public function reject(Teacher $teacher)
    {
        $this->authorize('update', $teacher);

        $teacher->user->update([
            'status' => 'rejected'
        ]);

        $teacher->load('user');

        return $this->success(
            new TeacherResource($teacher),
            'Docente rejeitado com sucesso.'
        );
    }
    public function pending()
    {
        $this->authorize('viewAny', Teacher::class);

        $teachers = Teacher::with('user')
            ->whereHas('user', function ($query) {
                $query->where('status', 'pending');
            })
            ->get();

        return $this->success(
            TeacherResource::collection($teachers),
            'Docentes pendentes listados com sucesso.'
        );
    }
}
