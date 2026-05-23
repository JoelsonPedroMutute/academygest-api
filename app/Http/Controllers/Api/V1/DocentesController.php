<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreDocenteRequest;
use App\Http\Requests\UpdateDocenteRequest;
use App\Http\Requests\IndexDocenteRequest;

use App\Http\Resources\DocenteResource;

use App\Models\Docente;
use App\Services\DocenteService;
use Illuminate\Support\Facades\Auth;

class DocentesController extends BaseController
{
    public function __construct(
        protected DocenteService $docenteService
    ) {}

    /*
    |--------------------------------------------------------------------------
    | LISTAGEM
    |--------------------------------------------------------------------------
    */
    public function index(IndexDocenteRequest $request)
    {
        $this->authorize('viewAny', Docente::class);

        $docentes = $this->docenteService->listarFiltrado(
            $request->validated()
        );

        return DocenteResource::collection($docentes);
    }

    /*
    |--------------------------------------------------------------------------
    | DETALHE
    |--------------------------------------------------------------------------
    */
    public function show(Docente $docente)
    {
        $this->authorize('view', $docente);

        $docente->load([
            'user',
            'disciplinas',
            'turmas',
        ]);

        return new DocenteResource($docente);
    }

    /*
    |--------------------------------------------------------------------------
    | CRIAÇÃO
    |--------------------------------------------------------------------------
    */
    public function store(StoreDocenteRequest $request)
    {
        $this->authorize('create', Docente::class);

        $docente = $this->docenteService->criar(
            $request->validated()
        );

        $docente->load([
            'user',
            'disciplinas',
            'turmas',
        ]);

        return new DocenteResource($docente);
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAÇÃO
    |--------------------------------------------------------------------------
    */
    public function update(UpdateDocenteRequest $request, Docente $docente)
    {
        $this->authorize('update', $docente);

        $docente = $this->docenteService->atualizar(
            $docente->id,
            $request->validated()
        );

        $docente->load([
            'user',
            'disciplinas',
            'turmas',
        ]);

        return new DocenteResource($docente);
    }

    /*
    |--------------------------------------------------------------------------
    | REMOÇÃO
    |--------------------------------------------------------------------------
    */
    public function destroy(Docente $docente)
    {
        $this->authorize('delete', $docente);

        $this->docenteService->deletar($docente->id);

        return $this->success(
            'Docente eliminado com sucesso.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PERFIL DO DOCENTE AUTENTICADO
    |--------------------------------------------------------------------------
    */
    public function meuPerfil()
    {
        $docente = $this->docenteService->buscarPorUser(
            Auth::id()
        );

        abort_if(!$docente, 404);

        $docente->load([
            'user',
            'disciplinas',
            'turmas',
        ]);

        return new DocenteResource($docente);
    }

    public function actualizarMeuPerfil(UpdateDocenteRequest $request)
    {
        $docente = $this->docenteService->buscarPorUser(
            Auth::id()
        );

        abort_if(!$docente, 404);

        $this->authorize('update', $docente);

        $docente = $this->docenteService->atualizar(
            $docente->id,
            $request->validated()
        );

        $docente->load([
            'user',
            'disciplinas',
            'turmas',
        ]);

        return new DocenteResource($docente);
    }
}
