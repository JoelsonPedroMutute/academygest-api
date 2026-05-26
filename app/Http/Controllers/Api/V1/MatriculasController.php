<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreMatriculaRequest;
use App\Http\Requests\UpdateMatriculaRequest;
use App\Http\Requests\IndexMatriculaRequest;

use App\Http\Resources\MatriculaResource;

use App\Models\Matricula;
use App\Services\MatriculaService;

class MatriculasController extends BaseController
{
    public function __construct(
        protected MatriculaService $matriculaService
    ) {}


    public function index(IndexMatriculaRequest $request)
    {
        $this->authorize('viewAny', Matricula::class);

        $matriculas = $this->matriculaService->listarFiltrado($request->validated());

        return $this->success(
            MatriculaResource::collection($matriculas),
            'Matrículas listadas com sucesso.'
        );
    }

    public function show(Matricula $matricula)
    {
        $this->authorize('view', $matricula);

        $matricula->load(['aluno', 'turma']);

        return $this->success(
            new MatriculaResource($matricula),
            'Matrícula encontrada com sucesso.'
        );
    }

    public function store(StoreMatriculaRequest $request)
    {
        $this->authorize('create', Matricula::class);

        $matricula = $this->matriculaService->criar($request->validated());

        $matricula->load(['aluno', 'turma']);

        return $this->success(
            new MatriculaResource($matricula),
            'Matrícula criada com sucesso.',
            201
        );
    }

    public function update(UpdateMatriculaRequest $request, Matricula $matricula)
    {
        $this->authorize('update', $matricula);

        $matricula = $this->matriculaService->atualizar($matricula->id, $request->validated());

        return $this->success(
            new MatriculaResource($matricula),
            'Matrícula actualizada com sucesso.'
        );
    }

    public function destroy(Matricula $matricula)
    {
        $this->authorize('delete', $matricula);

        $this->matriculaService->deletar($matricula->id);

        return $this->success(null, 'Matrícula eliminada com sucesso.');
    }
}
