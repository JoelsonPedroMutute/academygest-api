<?php

namespace App\Services;

use App\Filters\AlunoFilter;
use App\Models\Aluno;

use Illuminate\Support\Facades\DB;

class AlunoService extends BaseService
{
    public function __construct(
        protected AlunoFilter $filter,
        protected UserService $userService
    ) {
        $this->model = Aluno::class;
    }

    /*
    |----------------------------------------------------------------------
    | LISTAGEM
    |----------------------------------------------------------------------
    */
    public function listarFiltrado(array $filtros = [])
    {
        $query = Aluno::query()->with(['user', 'turma']);

        $this->filter->apply($query, $filtros);

        return $query->latest()->paginate(10)->withQueryString();
    }

    public function listarEliminados()
    {
        return Aluno::onlyTrashed()
            ->with(['user', 'turma'])
            ->latest()
            ->paginate(10);
    }

    /*
    |----------------------------------------------------------------------
    | CRIAÇÃO
    |----------------------------------------------------------------------
    */
    public function criar(array $dados, string $context = 'public'): Aluno
    {
        return DB::transaction(function () use ($dados, $context) {

            $user = $this->userService->criar([
                'name'     => $dados['name'],
                'email'    => $dados['email'],
                'password' => $dados['password'],
                'role'     => 'aluno',
                'status'   => 'active',
            ]);

            //  Gera número de estudante automaticamente
            $numeroEstudante = 'EST' . date('Y') . str_pad($user->id, 4, '0', STR_PAD_LEFT);

            return Aluno::create([
                'user_id'          => $user->id,
                'data_nascimento'  => $dados['data_nascimento'],
                'numero_estudante' => $numeroEstudante,
                'turma_id'         => $dados['turma_id'],
            ]);
        });
    }
    /*
    |----------------------------------------------------------------------
    | ATUALIZAÇÃO
    |----------------------------------------------------------------------
    */
    public function atualizar(int $id, array $dados): Aluno
    {
        return DB::transaction(function () use ($id, $dados) {

            $aluno = $this->buscarPorId($id);

            $this->userService->atualizar($aluno->user, $dados);

            $aluno->update(array_filter([
                'data_nascimento'  => $dados['data_nascimento']  ?? null,
                'numero_estudante' => $dados['numero_estudante'] ?? null,
                'turma_id'         => $dados['turma_id']         ?? null,
            ], fn($value) => $value !== null)); //  só actualiza o que veio

            return $aluno->fresh(['user', 'turma']);
        });
    }

    /*
    |----------------------------------------------------------------------
    | ELIMINAÇÃO
    |----------------------------------------------------------------------
    */
    public function deletar(int $id): void
    {
        $aluno = $this->buscarPorId($id);

        DB::transaction(function () use ($aluno) {
            $aluno->user->delete();
            $aluno->delete();
        });
    }

    /*
    |----------------------------------------------------------------------
    | RESTAURAR
    |----------------------------------------------------------------------
    */
    public function restaurar(int $id): bool
    {
        $aluno = Aluno::onlyTrashed()->findOrFail($id);

        return DB::transaction(function () use ($aluno) {
            $aluno->restore();
            $aluno->user()->withTrashed()->restore();

            return true;
        });
    }

    /*
    |----------------------------------------------------------------------
    | ESTADO
    |----------------------------------------------------------------------
    */
    public function activar(int $id): bool
    {
        $aluno = $this->buscarPorId($id);

        return $this->userService->activar($aluno->user);
    }

    public function desactivar(int $id): bool
    {
        $aluno = $this->buscarPorId($id);

        return $this->userService->desactivar($aluno->user);
    }

    /*
    |----------------------------------------------------------------------
    | PERFIL
    |----------------------------------------------------------------------
    */
    public function buscarPorUser(int $userId): Aluno
    {
        return Aluno::with(['user', 'turma'])
            ->where('user_id', $userId)
            ->firstOrFail();
    }
}
