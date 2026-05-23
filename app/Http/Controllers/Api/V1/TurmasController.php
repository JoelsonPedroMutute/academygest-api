<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreTurmaRequest;
use App\Http\Requests\UpdateTurmaRequest;
use App\Http\Requests\IndexTurmaRequest;

use App\Http\Resources\TurmaResource;

use App\Models\Turma;
use App\Services\TurmaService;

class TurmasController extends BaseController
{
    public function __construct(
        protected TurmaService $turmaService
    ) {}

    /*
    |--------------------------------------------------------------------------
    | LISTAGEM
    |--------------------------------------------------------------------------
    */
    public function index(IndexTurmaRequest $request)
    {
        $this->authorize('viewAny', Turma::class);

        $turmas = $this->turmaService->listarFiltrado(
            $request->validated()
        );

        return TurmaResource::collection($turmas);
    }

    /*
    |--------------------------------------------------------------------------
    | DETALHE
    |--------------------------------------------------------------------------
    */
    public function show(Turma $turma)
    {
        $this->authorize('view', $turma);

        $turma->load([
            'curso',
            'alunos',
            'disciplinas',
        ]);

        return new TurmaResource($turma);
    }

    /*
    |--------------------------------------------------------------------------
    | CRIAÇÃO
    |--------------------------------------------------------------------------
    */
    public function store(StoreTurmaRequest $request)
    {
        $this->authorize('create', Turma::class);

        $turma = $this->turmaService->criar(
            $request->validated()
        );

        $turma->load([
            'curso',
            'alunos',
            'disciplinas',
        ]);

        return new TurmaResource($turma);
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAÇÃO
    |--------------------------------------------------------------------------
    */
    public function update(UpdateTurmaRequest $request, Turma $turma)
    {
        $this->authorize('update', $turma);

        $turma = $this->turmaService->atualizar(
            $turma->id,
            $request->validated()
        );

        $turma->load([
            'curso',
            'alunos',
            'disciplinas',
        ]);

        return new TurmaResource($turma);
    }

    /*
    |--------------------------------------------------------------------------
    | REMOÇÃO
    |--------------------------------------------------------------------------
    */
    public function destroy(Turma $turma)
    {
        $this->authorize('delete', $turma);

        $this->turmaService->deletar($turma->id);

        return $this->success(
            'Turma eliminada com sucesso.'
        );
    }
}
