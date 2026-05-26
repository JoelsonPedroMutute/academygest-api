<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
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


    public function index(IndexAlunoRequest $request)
    {
        $this->authorize('viewAny', Aluno::class);

        $alunos = $this->alunoService->listarFiltrado($request->validated());

        return $this->success(
            AlunoResource::collection($alunos),
            'Alunos listados com sucesso.'
        );
    }

    public function show(Aluno $aluno)
    {
        $this->authorize('view', $aluno);

        $aluno->load(['turma', 'notas']);

        return $this->success(
            new AlunoResource($aluno),
            'Aluno encontrado com sucesso.'
        );
    }

    public function store(StoreAlunoRequest $request)
    {
        $this->authorize('create', Aluno::class);

        $aluno = $this->alunoService->criar($request->validated(), 'admin');

        $aluno->load(['turma']);

        return $this->success(
            new AlunoResource($aluno),
            'Aluno criado com sucesso.',
            201
        );
    }

    public function update(UpdateAlunoRequest $request, Aluno $aluno)
    {
        $this->authorize('update', $aluno);

        $aluno = $this->alunoService->atualizar($aluno->id, $request->validated());

        $aluno->load(['turma']);

        return $this->success(
            new AlunoResource($aluno),
            'Aluno actualizado com sucesso.'
        );
    }
    public function destroy(Aluno $aluno)
    {
        $this->authorize('delete', $aluno);

        $this->alunoService->deletar($aluno->id);

        return $this->success(null, 'Aluno eliminado com sucesso.');
    }

    public function meuPerfil()
    {
        $aluno = $this->alunoService->buscarPorUser(Auth::id());

        abort_if(!$aluno, 404);

        $aluno->load(['turma', 'notas']);

        return $this->success(
            new AlunoResource($aluno),
            'Perfil carregado com sucesso.'
        );
    }

    public function atualizarMeuPerfil(Request $request)
    {
        $aluno = $request->user()->aluno;

        $data = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email',
            'data_nascimento' => 'sometimes|date',
            'numero_estudante' => 'sometimes|string',
            'turma_id' => 'sometimes|integer',
        ]);

        $aluno = $this->alunoService->atualizar(
            $aluno->id,
            $data
        );

        return response()->json([
            'message' => 'Perfil atualizado com sucesso.',
            'data' => $aluno
        ]);
    }

    public function trashed()
    {
        $this->authorize('viewAny', Aluno::class);

        $alunos = $this->alunoService->listarEliminados();

        return $this->success(
            AlunoResource::collection($alunos),
            'Alunos eliminados listados com sucesso.'
        );
    }

    public function restore(Aluno $aluno)
    {
        $this->authorize('restore', Aluno::class);

        $this->alunoService->restaurar($aluno->id);

        return $this->success(null, 'Aluno restaurado com sucesso.');
    }
}
