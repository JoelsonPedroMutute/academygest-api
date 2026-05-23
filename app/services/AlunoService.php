<?php

namespace App\Services;

use App\Filters\AlunoFilter;
use App\Models\Aluno;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AlunoService extends BaseService
{
    public function __construct(
        protected AlunoFilter $filter
    ) {
        $this->model = Aluno::class;
    }

    /*
    |--------------------------------------------------------------------------
    | LISTAGEM
    |--------------------------------------------------------------------------
    */

    public function listarFiltrado(array $filtros = [])
    {
        $query = Aluno::query()
            ->with(['user', 'turma']);

        $this->filter->apply($query, $filtros);

        return $query
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    public function listarEliminados()
    {
        return Aluno::onlyTrashed()
            ->with(['user', 'turma'])
            ->latest()
            ->paginate(10);
    }

    /*
    |--------------------------------------------------------------------------
    | CRIAÇÃO
    |--------------------------------------------------------------------------
    */

    public function criar(array $dados): Aluno
    {
        return DB::transaction(function () use ($dados) {

            $user = User::create([
                'name'     => $dados['name'],
                'email'    => $dados['email'],
                'password' => Hash::make($dados['password']),
                'role'     => 'aluno',
                'activo'   => true,
            ]);

            return Aluno::create([
                'user_id'          => $user->id,
                'data_nascimento'  => $dados['data_nascimento'],
                'numero_estudante' => $dados['numero_estudante'],
                'turma_id'         => $dados['turma_id'],
            ]);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAÇÃO
    |--------------------------------------------------------------------------
    */

    public function atualizar(int $id, array $dados): Aluno
    {
        return DB::transaction(function () use ($id, $dados) {

            $aluno = $this->buscarPorId($id);

            $aluno->user->update([
                'name'  => $dados['name'],
                'email' => $dados['email'],
            ]);

            if (!empty($dados['password'])) {
                $aluno->user->update([
                    'password' => Hash::make($dados['password'])
                ]);
            }

            $aluno->update([
                'data_nascimento'  => $dados['data_nascimento'],
                'numero_estudante' => $dados['numero_estudante'],
                'turma_id'         => $dados['turma_id'],
            ]);

            return $aluno->fresh();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | REMOÇÃO
    |--------------------------------------------------------------------------
    */

    public function deletar(int $id): void
    {
        $aluno = $this->buscarPorId($id);

        DB::transaction(function () use ($aluno) {
            $aluno->user->delete();
            $aluno->delete();
        });
    }

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
    |--------------------------------------------------------------------------
    | ESTADO
    |--------------------------------------------------------------------------
    */

    public function activar(int $id): bool
    {
        $aluno = $this->buscarPorId($id);

        return $aluno->user->update([
            'activo' => true
        ]);
    }

    public function desactivar(int $id): bool
    {
        $aluno = $this->buscarPorId($id);

        return $aluno->user->update([
            'activo' => false
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PERFIL
    |--------------------------------------------------------------------------
    */

    public function buscarPorUser(int $userId): Aluno
    {
        return Aluno::with(['user', 'turma'])
            ->where('user_id', $userId)
            ->firstOrFail();
    }
}
