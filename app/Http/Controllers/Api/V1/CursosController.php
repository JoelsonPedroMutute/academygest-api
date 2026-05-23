<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreCursoRequest;
use App\Http\Requests\UpdateCursoRequest;
use App\Http\Requests\IndexCursoRequest;
use App\Http\Resources\CursoResource;
use App\Models\Curso;
use App\Services\CursoService;

class CursosController extends BaseController
{
    public function __construct(
        protected CursoService $cursoService
    ) {}

    /*
    |--------------------------------------------------------------------------
    | LISTAGEM
    |--------------------------------------------------------------------------
    */
    public function index(IndexCursoRequest $request)
    {
        $this->authorize('viewAny', Curso::class);

        $cursos = $this->cursoService->listarFiltrado(
            $request->validated()
        );

        return CursoResource::collection($cursos);
    }

    /*
    |--------------------------------------------------------------------------
    | DETALHE
    |--------------------------------------------------------------------------
    */
    public function show(Curso $curso)
    {
        $this->authorize('view', $curso);

        $curso->load([
            'disciplinas',
            'turmas',
        ]);

        return new CursoResource($curso);
    }

    /*
    |--------------------------------------------------------------------------
    | CRIAÇÃO
    |--------------------------------------------------------------------------
    */
    public function store(StoreCursoRequest $request)
    {
        $this->authorize('create', Curso::class);

        $curso = $this->cursoService->criar(
            $request->validated()
        );

        $curso->load([
            'disciplinas',
            'turmas',
        ]);

        return new CursoResource($curso);
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAÇÃO
    |--------------------------------------------------------------------------
    */
    public function update(UpdateCursoRequest $request, Curso $curso)
    {
        $this->authorize('update', $curso);

        $curso = $this->cursoService->atualizar(
            $curso->id,
            $request->validated()
        );

        $curso->load([
            'disciplinas',
            'turmas',
        ]);

        return new CursoResource($curso);
    }

    /*
    |--------------------------------------------------------------------------
    | REMOÇÃO
    |--------------------------------------------------------------------------
    */
    public function destroy(Curso $curso)
    {
        $this->authorize('delete', $curso);

        $this->cursoService->deletar($curso->id);

        return $this->success(
            'Curso eliminado com sucesso.'
        );
    }
}
