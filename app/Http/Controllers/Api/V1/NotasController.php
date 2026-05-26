<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreNotaRequest;
use App\Http\Requests\UpdateNotaRequest;
use App\Http\Requests\IndexNotaRequest;

use App\Http\Resources\NotaResource;

use App\Models\Nota;
use App\Services\NotasService;
use Illuminate\Support\Facades\Auth;



class NotasController extends BaseController
{
    public function __construct(
        protected NotasService $notaService
    ) {}


    public function index(IndexNotaRequest $request)
    {
        $this->authorize('viewAny', Nota::class);

        $notas = $this->notaService->listarFiltrado($request->validated());

        return $this->success(
            NotaResource::collection($notas),
            'Notas listadas com sucesso.'
        );
    }

    public function show(Nota $nota)
    {
        $this->authorize('view', $nota);

        $nota->load(['aluno', 'disciplina', 'turma']);

        return $this->success(
            new NotaResource($nota),
            'Nota encontrada com sucesso.'
        );
    }


    public function store(StoreNotaRequest $request)
    {

        $this->authorize('create', Nota::class);

        $nota = $this->notaService->criar($request->validated());

        $nota->load(['aluno', 'disciplina', 'turma']);

        return $this->success(
            new NotaResource($nota),
            'Nota criada com sucesso.',
            201
        );
    }
    public function minhasNotas()
    {
        $user = Auth::user();

        if (!$user->aluno) {
            return $this->error('Aluno não encontrado para este utilizador', 404);
        }

        $notas = Nota::with(['disciplina', 'turma'])
            ->where('aluno_id', $user->aluno->id)
            ->get();

        return $this->success($notas, 'Notas carregadas com sucesso.');
    }


    public function update(UpdateNotaRequest $request, Nota $nota)
    {
        $this->authorize('update', $nota);

        $nota = $this->notaService->atualizar($nota->id, $request->validated());

        return $this->success(
            new NotaResource($nota),
            'Nota actualizada com sucesso.'
        );
    }

    public function destroy(Nota $nota)
    {
        $this->authorize('delete', $nota);

        $this->notaService->deletar($nota->id);

        return $this->success(null, 'Nota eliminada com sucesso.');
    }
}
