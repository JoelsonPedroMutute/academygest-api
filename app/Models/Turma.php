<?php

namespace App\Models;

use App\Filters\TurmaFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'curso_id',
        'ano_letivo',
        'semestre',
        'capacidade',
        'turno',
    ];

    public function scopeFiltered(Builder $query, array $filters)
    {
        return TurmaFilter::apply($query, $filters);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'turma_disciplina');
    }
}
