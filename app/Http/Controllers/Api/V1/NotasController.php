<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreNotaRequest;
use App\Http\Requests\UpdateNotaRequest;
use App\Http\Requests\IndexNotaRequest;

use App\Http\Resources\NotaResource;

use App\Models\Nota;
use App\Services\NotasService;

class NotasController extends BaseController
{
    public function __construct(
        protected NotasService $notaService
    ) {}

    /*
    |--------------------------------------------------------------------------
    | LISTAGEM
    |--------------------------------------------------------------------------
    */
    public function index(IndexNotaRequest $request)
    {
        $this->authorize('viewAny', Nota::class);

        $notas = $this->notaService->listarFiltrado(
            $request->validated()
        );

        return NotaResource::collection($notas);
    }

    /*
    |--------------------------------------------------------------------------
    | DETALHE
    |--------------------------------------------------------------------------
    */
    public function show(Nota $nota)
    {
        $this->authorize('view', $nota);

        $nota->load([
            'aluno',
            'disciplina',
            'turma',
        ]);

        return new NotaResource($nota);
    }

    /*
    |--------------------------------------------------------------------------
    | CRIAÇÃO
    |--------------------------------------------------------------------------
    */
    public function store(StoreNotaRequest $request)
    {
        $this->authorize('create', Nota::class);

        $nota = $this->notaService->criar(
            $request->validated()
        );

        $nota->load([
            'aluno',
            'disciplina',
            'turma',
        ]);

        return new NotaResource($nota);
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAÇÃO
    |--------------------------------------------------------------------------
    */
    public function update(UpdateNotaRequest $request, Nota $nota)
    {
        $this->authorize('update', $nota);

        $nota = $this->notaService->atualizar(
            $nota->id,
            $request->validated()
        );

        $nota->load([
            'aluno',
            'disciplina',
            'turma',
        ]);

        return new NotaResource($nota);
    }

    /*
    |--------------------------------------------------------------------------
    | REMOÇÃO
    |--------------------------------------------------------------------------
    */
    public function destroy(Nota $nota)
    {
        $this->authorize('delete', $nota);

        $this->notaService->deletar($nota->id);

        return $this->success(
            'Nota eliminada com sucesso.'
        );
    }
}
