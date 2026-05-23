<?php

namespace App\Models;

use App\Filters\MatriculaFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Matricula extends Model
{
    use HasFactory;
    protected $fillable = [
        'aluno_id',
        'turma_id',
        'ano_letivo',
        'semestre',
        'data_matricula',
        'status',
    ];

    public function scopeFiltered(Builder $query, array $filters)
    {
        return MatriculaFilter::apply($query, $filters);
    }
    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
}
