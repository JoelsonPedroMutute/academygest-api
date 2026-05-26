<?php

namespace App\Models;

use App\Filters\CursoFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'duracao',
    ];
    public function scopeFiltered(Builder $query, array $filters)
    {
        return CursoFilter::apply($query, $filters);
    }

    public function turmas()
    {
        return $this->hasMany(Turma::class);
    }
    public function disciplinas()
    {
        return $this->hasMany(Disciplina::class);
    }
}
