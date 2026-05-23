<?php

namespace App\Models;

use App\Filters\NotaFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Nota extends Model
{
    use HasFactory;
    protected $fillable = [
        'aluno_id',
        'disciplina_id',
        'turma_id',
        'prova_trimestral1',
        'prova_trimestral2',
        'prova_trimestral3',
        'exame_final',
        'media_final',
        'situacao',
    ];

    public function scopeFiltered(Builder $query, array $filters)
    {
        return NotaFilter::apply($query, $filters);
    }
    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }
    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
}
