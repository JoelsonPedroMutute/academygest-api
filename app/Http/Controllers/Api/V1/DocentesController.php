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

        return $this->success(
            DocenteResource::collection($docentes),
            'Docentes listados com sucesso.'
        );
    }

    public function show(Docente $docente)
    {
        $this->authorize('view', $docente);

        $docente->load(['user']);

        return $this->success(
            new DocenteResource($docente),
            'Docente encontrado com sucesso.'
        );
    }

    public function store(StoreDocenteRequest $request)
    {
        $this->authorize('create', Docente::class);

        $docente = $this->docenteService->criar(
            $request->validated(),
            'admin'
        );

        return $this->success(
            new DocenteResource($docente),
            'Docente criado com sucesso.',
            201
        );
    }

    public function update(UpdateDocenteRequest $request, Docente $docente)
    {
        $this->authorize('update', $docente);

        $docente = $this->docenteService->atualizar(
            $docente->id,
            $request->validated()
        );

        $docente->load(['user']);

        return $this->success(
            new DocenteResource($docente),
            'Docente actualizado com sucesso.'
        );
    }

    public function meuPerfil()
    {
        $docente = $this->docenteService->buscarPorUser(Auth::id());

        abort_if(!$docente, 404);

        $docente->load(['user']);

        return $this->success(
            new DocenteResource($docente),
            'Perfil carregado com sucesso.'
        );
    }
    public function actualizarMeuPerfil(UpdateDocenteRequest $request)
    {
        $docente = $this->docenteService->buscarPorUser(Auth::id());
        abort_if(!$docente, 404);

        // REMOVA ESTA LINHA - não precisa pois você já tem o docente correto
        // $this->authorize('update', $docente);

        $docente = $this->docenteService->atualizar(
            $docente->id,
            $request->validated()
        );

        $docente->load(['user']);

        return $this->success(
            new DocenteResource($docente),
            'Perfil actualizado com sucesso.'
        );
    }


    public function approve(Docente $docente)
    {
        $this->authorize('update', $docente);

        $docente->user->update([
            'status' => 'approved'
        ]);

        $docente->load('user');

        return $this->success(
            new DocenteResource($docente),
            'Docente aprovado com sucesso.'
        );
    }

    public function reject(Docente $docente)
    {
        $this->authorize('update', $docente);

        $docente->user->update([
            'status' => 'rejected'
        ]);

        $docente->load('user');

        return $this->success(
            new DocenteResource($docente),
            'Docente rejeitado com sucesso.'
        );
    }
    public function pending()
    {
        $this->authorize('viewAny', Docente::class);

        $docentes = Docente::with('user')
            ->whereHas('user', function ($query) {
                $query->where('status', 'pending');
            })
            ->get();

        return $this->success(
            DocenteResource::collection($docentes),
            'Docentes pendentes listados com sucesso.'
        );
    }
}
