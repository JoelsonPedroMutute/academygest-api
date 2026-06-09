<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseService
{
    protected string $model;

    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return ($this->model)::query()->paginate($perPage);
    }

    public function create(array $data): Model
    {
        return ($this->model)::create($data);
    }

    public function findById(int $id): Model
    {
        return ($this->model)::findOrFail($id);
    }

    public function update(int $id, array $data): Model
    {
        $model = $this->findById($id);
        $model->update($data);

        return $model->fresh();
    }

    public function delete(int $id): void
    {
        $this->findById($id)->delete();
    }

    public function total(): int
    {
        return ($this->model)::count();
    }

    public function recent(int $limit = 5)
    {
        return ($this->model)::latest()->limit($limit)->get();
    }
}