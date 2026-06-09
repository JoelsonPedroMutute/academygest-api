<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Requests\IndexStudentRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

use App\Http\Resources\StudentResource;

use App\Models\Student;

use App\Services\StudentService;
use Illuminate\Support\Facades\Auth;

class StudentController extends BaseController
{
    public function __construct(
        protected StudentService $studentService
    ) {}


    public function index(IndexStudentRequest $request)
    {
        $this->authorize('viewAny', Student::class);

        $students = $this->studentService->listFiltered($request->validated());

        return $this->success(
            StudentResource::collection($students),
            'Alunos listados com sucesso.'
        );
    }

    public function show(Student $student)
    {
        $this->authorize('view', $student);

        $student->load(['turma', 'notas']);

        return $this->success(
            new StudentResource($student),
            'Aluno encontrado com sucesso.'
        );
    }

    public function store(StoreStudentRequest $request)
    {
        $this->authorize('create', Student::class);

        $student = $this->studentService->create($request->validated(), 'admin');

        $student->load(['turma']);

        return $this->success(
            new StudentResource($student),
            'Aluno criado com sucesso.',
            201
        );
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $this->authorize('update', $student);

        $student = $this->studentService->update($student->id, $request->validated());

        $student->load(['turma']);

        return $this->success(
            new StudentResource($student),
            'Aluno actualizado com sucesso.'
        );
    }
    public function destroy(Student $student)
    {
        $this->authorize('delete', $student);

        $this->studentService->delete($student->id);

        return $this->success(null, 'Aluno eliminado com sucesso.');
    }

    public function meuPerfil()
    {
        $student = $this->studentService->findByUser(Auth::id());

        abort_if(!$student, 404);

        $student->load(['turma', 'notas']);

        return $this->success(
            new StudentResource($student),
            'Perfil carregado com sucesso.'
        );
    }

    public function atualizarMeuPerfil(Request $request)
    {
        $student = $request->user()->student;

        $data = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email',
            'data_nascimento' => 'sometimes|date',
            'numero_estudante' => 'sometimes|string',
            'turma_id' => 'sometimes|integer',
        ]);

        $student = $this->studentService->update(
            $student->id,
            $data
        );

        return response()->json([
            'message' => 'Perfil atualizado com sucesso.',
            'data' => $student
        ]);
    }

    public function trashed()
    {
        $this->authorize('viewAny', Student::class);

        $students = $this->studentService->listTrashed();

        return $this->success(
            StudentResource::collection($students),
            'Alunos eliminados listados com sucesso.'
        );
    }

    public function restore(Student $student)
    {
        $this->authorize('restore', Student::class);

        $this->studentService->restore($student->id);

        return $this->success(null, 'Aluno restaurado com sucesso.');
    }
}
