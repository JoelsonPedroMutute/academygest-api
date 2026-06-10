<?php

namespace App\Services;

use App\Filters\CourseFilter;
use App\Models\Course;
use App\Services\BaseService;


class CourseService extends BaseService
{
    public function __construct(
        protected CourseFilter $filter
    ) {
        $this->model = Course::class;
    }
    public function listarFiltrado(array $filtros = [])
    {
        $query = Course::query()
            ->with(['subjects', 'classes']);

        $this->filter->apply($query, $filtros);

        return $query
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }


    // Sobrescreve — validação de nome duplicado
    public function criar(array $dados): Course
    {
        if (Course::where('name', $dados['name'])->exists()) {
            throw new \Exception('Já existe um curso com esse nome.');
        }

        return parent::create($dados);
    }

    // Sobrescreve — validação de nome duplicado
    public function atualizar(int $id, array $dados): Course
    {
        if (Course::where('name', $dados['name'])
            ->where('id', '!=', $id)->exists()
        ) {
            throw new \Exception('Já existe um curso com esse nome.');
        }

        return parent::update($id, $dados);
    }
    public   function eliminar(int $id): bool
    {
        return Course::destroy($id);
    }
}
