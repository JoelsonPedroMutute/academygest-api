<?php

namespace App\Models;

use App\Filters\DisciplinaFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Disciplina extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'carga_horaria',
        'curso_id',
    ];

    public function scopeFiltered(Builder $query, array $filters)
    {
        return DisciplinaFilter::apply($query, $filters);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function turma()
    {
        return $this->belongsToMany(Turma::class, 'turma_disciplina');
    }
    public function docentes()
    {
        return $this->belongsToMany(Docente::class, 'disciplina_docente');
    }
}
