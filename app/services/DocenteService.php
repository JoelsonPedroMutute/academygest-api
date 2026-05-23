<?php

namespace App\Services;

use App\Models\Docente;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Filters\DocenteFilter;

class DocenteService extends BaseService
{
    public function __construct(
        protected DocenteFilter $filter
    ) {
        $this->model = Docente::class;
    }
    public function listarFiltrado(array $filtros = [])
    {
        $query = Docente::query()
            ->with([
                'user',
                'disciplinas',
                'turmas'
            ]);

        $this->filter->apply($query, $filtros);

        return $query
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    public function buscarPorUser(int $userId): Docente
    {
        return Docente::with(['user'])
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    //--- Sobrescreve criar ---//

    public function criar(array $dados): Docente
    {
        return DB::transaction(function () use ($dados) {

            $user = User::create([
                'name'     => $dados['name'],
                'email'    => $dados['email'],
                'password' => Hash::make($dados['password']),
                'tipo'     => 'docente', // ← 'tipo' conforme a tua migration
            ]);

            return Docente::create([
                'user_id'         => $user->id,
                'data_nascimento' => $dados['data_nascimento'],
                'especialidade'   => $dados['especialidade'],
                'telefone'        => $dados['telefone'],
            ]);
        });
    }

    // ─── Sobrescreve atualizar ---//

    public function atualizar(int $id, array $dados): Docente
    {
        return DB::transaction(function () use ($id, $dados) {

            $docente = $this->buscarPorId($id);

            // 1. Primeiro actualiza o user
            $docente->user->update([
                'name'  => $dados['name'],
                'email' => $dados['email'],
            ]);

            // 2. Depois actualiza o docente
            $docente->update([
                'data_nascimento' => $dados['data_nascimento'],
                'especialidade'   => $dados['especialidade'],
                'telefone'        => $dados['telefone'],
            ]);

            // 3. Um único return no fim
            return $docente->fresh();
        });
    }
}
