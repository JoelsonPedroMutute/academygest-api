<?php

namespace App\Models;

use App\Filters\StudentFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Student extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'birth_date',
        'class_id',
        'student_number',
    ];

    public function scopeFiltered(Builder $query, array $filters): Builder
    {
        return StudentFilter::apply($query, $filters);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    // Antes
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function turma()
    {
        return $this->schoolClass();
    }
    public function notas()
    {
        return $this->hasMany(Grade::class);
    }
}
