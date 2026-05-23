<?php

namespace App\Models;

use App\Filters\DocenteFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Docente extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'data_nascimento',
        'especialidade',
    ];
    public function scopeFiltered(Builder $query, array $filters)
    {
        return DocenteFilter::apply($query, $filters);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
