<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreAlunoRequest;
use App\Http\Requests\UpdateAlunoRequest;
use App\Http\Requests\IndexAlunoRequest;
use App\Http\Resources\AlunoResource;
use App\Models\Aluno;
use App\Services\AlunoService;
use Illuminate\Support\Facades\Auth;

class AlunoController extends BaseController
{
    public function __construct(
        protected AlunoService $alunoService
    ) {}

    /*
    |--------------------------------------------------------------------------
    | LISTAGEM
    |--------------------------------------------------------------------------
    */
    public function index(IndexAlunoRequest $request)
    {
        $this->authorize('viewAny', Aluno::class);

        $alunos = $this->alunoService->listarFiltrado(
            $request->validated()
        );

        return AlunoResource::collection($alunos);
    }

    /*
    |--------------------------------------------------------------------------
    | DETALHE
    |--------------------------------------------------------------------------
    */
    public function show(Aluno $aluno)
    {
        $this->authorize('view', $aluno);

        $aluno->load([
            'turma',
            'encarregado',
            'notas',
        ]);

        return new AlunoResource($aluno);
    }

    /*
    |--------------------------------------------------------------------------
    | CRIAÇÃO
    |--------------------------------------------------------------------------
    */
    public function store(StoreAlunoRequest $request)
    {
        $this->authorize('create', Aluno::class);

        $aluno = $this->alunoService->criar(
            $request->validated()
        );

        $aluno->load([
            'turma',
            'encarregado',
        ]);

        return new AlunoResource($aluno);
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAÇÃO
    |--------------------------------------------------------------------------
    */
    public function update(UpdateAlunoRequest $request, Aluno $aluno)
    {
        $this->authorize('update', $aluno);

        $aluno = $this->alunoService->atualizar(
            $aluno->id,
            $request->validated()
        );

        $aluno->load([
            'turma',
            'encarregado',
        ]);

        return new AlunoResource($aluno);
    }

    /*
    |--------------------------------------------------------------------------
    | ELIMINAÇÃO
    |--------------------------------------------------------------------------
    */
    public function destroy(Aluno $aluno)
    {
        $this->authorize('delete', $aluno);

        $this->alunoService->deletar($aluno->id);

        return $this->success(
            'Aluno eliminado com sucesso.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ESTADO
    |--------------------------------------------------------------------------
    */
    public function activar(Aluno $aluno)
    {
        $this->authorize('update', $aluno);

        $this->alunoService->activar($aluno->id);

        return $this->success(
            'Aluno activado com sucesso.'
        );
    }

    public function desactivar(Aluno $aluno)
    {
        $this->authorize('update', $aluno);

        $this->alunoService->desactivar($aluno->id);

        return $this->success(
            'Aluno desactivado com sucesso.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PERFIL DO UTILIZADOR AUTENTICADO
    |--------------------------------------------------------------------------
    */
    public function meuPerfil()
    {
        $aluno = $this->alunoService->buscarPorUser(
            Auth::id()
        );

        abort_if(!$aluno, 404);

        $aluno->load([
            'turma',
            'encarregado',
            'notas',
        ]);

        return new AlunoResource($aluno);
    }

    public function actualizarMeuPerfil(UpdateAlunoRequest $request)
    {
        $aluno = $this->alunoService->buscarPorUser(
            Auth::id()
        );

        abort_if(!$aluno, 404);

        $this->authorize('update', $aluno);

        $aluno = $this->alunoService->atualizar(
            $aluno->id,
            $request->validated()
        );

        $aluno->load([
            'turma',
            'encarregado',
        ]);

        return new AlunoResource($aluno);
    }

    /*
    |--------------------------------------------------------------------------
    | LIXEIRA
    |--------------------------------------------------------------------------
    */
    public function trashed()
    {
        $this->authorize('viewAny', Aluno::class);

        $alunos = $this->alunoService->listarEliminados();

        return AlunoResource::collection($alunos);
    }

    public function restore(Aluno $aluno)
    {
        $this->authorize('restore', Aluno::class);

        $this->alunoService->restaurar($aluno->id);

        return $this->success(
            'Aluno restaurado com sucesso.'
        );
    }
}
