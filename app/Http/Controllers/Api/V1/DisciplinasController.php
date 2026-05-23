<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreDisciplinaRequest;
use App\Http\Requests\UpdateDisciplinaRequest;
use App\Http\Requests\IndexDisciplinaRequest;

use App\Http\Resources\DisciplinaResource;

use App\Models\Disciplina;
use App\Service\DisciplinasService;

class DisciplinasController extends BaseController
{
    public function __construct(
        protected DisciplinasService $disciplinaService
    ) {}

    /*
    |--------------------------------------------------------------------------
    | LISTAGEM
    |--------------------------------------------------------------------------
    */
    public function index(IndexDisciplinaRequest $request)
    {
        $this->authorize('viewAny', Disciplina::class);

        $disciplinas = $this->disciplinaService->listarFiltrado(
            $request->validated()
        );

        return DisciplinaResource::collection($disciplinas);
    }

    /*
    |--------------------------------------------------------------------------
    | DETALHE
    |--------------------------------------------------------------------------
    */
    public function show(Disciplina $disciplina)
    {
        $this->authorize('view', $disciplina);

        $disciplina->load([
            'curso',
            'professores',
        ]);

        return new DisciplinaResource($disciplina);
    }

    /*
    |--------------------------------------------------------------------------
    | CRIAÇÃO
    |--------------------------------------------------------------------------
    */
    public function store(StoreDisciplinaRequest $request)
    {
        $this->authorize('create', Disciplina::class);

        $disciplina = $this->disciplinaService->criar(
            $request->validated()
        );

        $disciplina->load([
            'curso',
            'professores',
        ]);

        return new DisciplinaResource($disciplina);
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAÇÃO
    |--------------------------------------------------------------------------
    */
    public function update(UpdateDisciplinaRequest $request, Disciplina $disciplina)
    {
        $this->authorize('update', $disciplina);

        $disciplina = $this->disciplinaService->atualizar(
            $disciplina->id,
            $request->validated()
        );

        $disciplina->load([
            'curso',
            'professores',
        ]);

        return new DisciplinaResource($disciplina);
    }

    /*
    |--------------------------------------------------------------------------
    | REMOÇÃO
    |--------------------------------------------------------------------------
    */
    public function destroy(Disciplina $disciplina)
    {
        $this->authorize('delete', $disciplina);

        $this->disciplinaService->deletar($disciplina->id);

        return $this->success(
            'Disciplina eliminada com sucesso.'
        );
    }
}
