<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\IndexGradeRequest;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Http\Resources\GradeResource;
use App\Models\Grade;

use App\Services\GradeService;

use Illuminate\Support\Facades\Auth;



class GradeController extends BaseController
{
    public function __construct(
        protected GradeService $gradeService
    ) {}


    public function index(IndexGradeRequest $request)
    {
        $this->authorize('viewAny', Grade::class);

        $grades = $this->gradeService->listFiltered($request->validated());

        return $this->success(
            GradeResource::collection($grades),
            'Notas listadas com sucesso.'
        );
    }

    public function show(Grade $grade)
    {
        $this->authorize('view', $grade);

        $grade->load(['students', 'disciplina', 'turma']);

        return $this->success(
            new GradeResource($grade),
            'Nota encontrada com sucesso.'
        );
    }


    public function store(StoreGradeRequest $request)
    {

        $this->authorize('create', Grade::class);

        $grade = $this->gradeService->create($request->validated());

        $grade->load(['students', 'subject', 'enrollment']);

        return $this->success(
            new GradeResource($grade),
            'Nota criada com sucesso.',
            201
        );
    }
    public function minhasNotas()
    {
        $user = Auth::user();

        if (!$user->aluno) {
            return $this->error('Aluno não encontrado para este utilizador', 404);
        }

        $grades = Grade::with(['students', 'subject', 'enrollment'])
            ->where('aluno_id', $user->aluno->id)
            ->get();

        return $this->success($grades, 'Notas carregadas com sucesso.');
    }


    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        $this->authorize('update', $grade);

        $grade = $this->gradeService->update($grade->id, $request->validated());

        return $this->success(
            new GradeResource($grade),
            'Nota actualizada com sucesso.'
        );
    }

    public function destroy(Grade $grade)
    {
        $this->authorize('delete', $grade);

        $this->gradeService->delete($grade->id);

        return $this->success(null, 'Nota eliminada com sucesso.');
    }
}
