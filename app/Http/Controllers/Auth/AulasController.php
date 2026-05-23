<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreAulaRequest;
use App\Http\Requests\UpdateAulaRequest;
use App\Models\Aula;
use App\Services\AulaService;
use Illuminate\Http\Request;

class AulasController extends BaseController
{
    public function __construct(
        protected AulaService $aulaService
    ) {}

    /*
    |--------------------------------------------------------------------------
    | LISTAGEM
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $this->authorize('viewAny', Aula::class);

        $filtros = $request->only([
            'search',
            'turma_id',
            'professor_id',
            'data',
        ]);

        $aulas = $this->aulaService->listarFiltrado($filtros);

        return view('admin.aulas.index', compact('aulas', 'filtros'));
    }

    /*
    |--------------------------------------------------------------------------
    | CRIAÇÃO
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $this->authorize('create', Aula::class);

        return view('admin.aulas.create');
    }

    public function store(StoreAulaRequest $request)
    {
        $this->authorize('create', Aula::class);

        $this->aulaService->criar(
            $request->validated()
        );

        return redirect()
            ->route('admin.aulas.index')
            ->with('success', 'Aula criada com sucesso.');
    }

    /*
    |--------------------------------------------------------------------------
    | VISUALIZAÇÃO
    |--------------------------------------------------------------------------
    */

    public function show(Aula $aula)
    {
        $this->authorize('view', $aula);

        $aula->load([
            'turma',
            'professor',
        ]);

        return view('admin.aulas.show', compact('aula'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIÇÃO
    |--------------------------------------------------------------------------
    */

    public function edit(Aula $aula)
    {
        $this->authorize('update', $aula);

        return view('admin.aulas.edit', compact('aula'));
    }

    public function update(UpdateAulaRequest $request, Aula $aula)
    {
        $this->authorize('update', $aula);

        $this->aulaService->atualizar(
            $aula->id,
            $request->validated()
        );

        return redirect()
            ->route('admin.aulas.index')
            ->with('success', 'Aula atualizada com sucesso.');
    }

    /*
    |--------------------------------------------------------------------------
    | REMOÇÃO
    |--------------------------------------------------------------------------
    */

    public function destroy(Aula $aula)
    {
        $this->authorize('delete', $aula);

        $this->aulaService->deletar($aula->id);

        return redirect()
            ->route('admin.aulas.index')
            ->with('success', 'Aula excluída com sucesso.');
    }
}
