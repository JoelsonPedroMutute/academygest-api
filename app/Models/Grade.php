<?php

namespace App\Models;

use App\Filters\GradeFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Grade extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'student_id',
        'subject_id',
        'class_id',
        'quarterly_exam',
        'semester_exam',
        'final_exam',
        'final_average',
        'status',
    ];

    public function scopeFiltered(Builder $query, array $filters): Builder
    {
        return GradeFilter::apply($query, $filters);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
}
