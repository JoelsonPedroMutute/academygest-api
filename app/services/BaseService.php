<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseService
{
    protected string $model;

    public function listar(int $perPage = 15): LengthAwarePaginator
    {
        return ($this->model)::query()->paginate($perPage);
    }

    public function criar(array $data): Model
    {
        return ($this->model)::create($data);
    }

    public function buscarPorId(int $id): Model
    {
        return ($this->model)::findOrFail($id);
    }

    public function atualizar(int $id, array $dados): Model
    {
        $model = $this->buscarPorId($id);
        $model->update($dados);

        return $model->fresh();
    }

    public function deletar(int $id): void
    {
        $this->buscarPorId($id)->delete();
    }

    //  ADDIÇÃO NECESSÁRIA
    public function total(): int
    {
        return ($this->model)::count();
    }

    public function recentes(int $limite = 5)
    {
        return ($this->model)::latest()->limit($limite)->get();
    }
}
