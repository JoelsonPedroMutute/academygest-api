<?php

namespace App\Models;

use App\Filters\AlunoFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Aluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'data_nascimento',
        'turma_id',
        'numero_estudante',
    ];

    public function scopeFiltered(Builder $query, array $filters)
    {
        return AlunoFilter::apply($query, $filters);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function notas()
    {
        return $this->hasMany(Nota::class);
    }
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
}
