<?php

namespace App\Services;

use App\Models\Docente;
use App\Filters\DocenteFilter;
use Illuminate\Support\Facades\DB;

class DocenteService extends BaseService
{
    public function __construct(
        protected DocenteFilter $filter,
        protected UserService $userService
    ) {
        $this->model = Docente::class;
    }

    public function listarFiltrado(array $filtros = [])
    {
        $query = Docente::query()
            ->with(['user']);

        $this->filter->apply($query, $filtros);

        return $query->latest()->paginate(10)->withQueryString();
    }


    public function criar(array $data, string $context = 'public'): Docente
    {
        return DB::transaction(function () use ($data, $context) {

            $isAdmin = $context === 'admin';

            $user = $this->userService->criar([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => $data['password'],
                'role'     => 'docente',
                'telefone' => $data['telefone'] ?? null,
                'status'   => $isAdmin ? 'active' : 'pending',
            ]);

            return Docente::create([
                'user_id'         => $user->id,
                'data_nascimento' => $data['data_nascimento'],
                'especialidade'   => $data['especialidade'],
                'telefone'        => $data['telefone'] ?? null,
                'status'          => $isAdmin ? 'active' : 'pending',
            ])->load([
                'user'
            ]);
        });
    }


    public function atualizar(int $id, array $dados): Docente
    {
        return DB::transaction(function () use ($id, $dados) {

            $docente = $this->buscarPorId($id);

            $this->userService->atualizar($docente->user, $dados);

            $docente->update(array_filter([
                'data_nascimento' => $dados['data_nascimento'] ?? null,
                'especialidade'   => $dados['especialidade'] ?? null,
                'telefone'        => $dados['telefone'] ?? null,
            ], fn($value) => $value !== null)); // ✅ só actualiza o que veio

            return $docente->fresh(['user']);
        });
    }



    public function buscarPorUser(int $userId): Docente
    {
        return Docente::with(['user'])
            ->where('user_id', $userId)
            ->firstOrFail();
    }
    public function listarPendentes()
    {
        return Docente::query()
            ->whereHas('user', function ($q) {
                $q->where('status', 'pending');
            })
            ->with(['user'])
            ->latest()
            ->paginate();
    }
    public function aprovar(Docente $docente): Docente
    {
        $docente->user->update([
            'status' => 'active'
        ]);

        return $docente->fresh(['user']);
    }

    public function rejeitar(Docente $docente): Docente
    {
        $docente->user->update([
            'status' => 'rejected'
        ]);

        return $docente->fresh(['user']);
    }
}
