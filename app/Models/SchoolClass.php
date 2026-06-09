<?php

namespace App\Models;

use App\Filters\SchoolClassFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SchoolClass extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'course_id',
        'academic_year',
        'semester',
        'capacity',
        'shift',
    ];

    public function scopeFiltered(Builder $query, array $filters): Builder
    {
        return SchoolClassFilter::apply($query, $filters);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
