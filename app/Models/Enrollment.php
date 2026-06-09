<?php

namespace App\Models;

use App\Filters\EnrollmentFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Enrollment extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'student_id',
        'class_id',
        'academic_year',
        'semester',
        'enrollment_date',
        'status',
    ];

    public function scopeFiltered(Builder $query, array $filters): Builder
    {
        return EnrollmentFilter::apply($query, $filters);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
}
