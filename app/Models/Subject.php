<?php

namespace App\Models;

use App\Filters\SubjectFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Subject extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'description',
        'workload',
        'course_id',
    ];

    public function scopeFiltered(Builder $query, array $filters): Builder
    {
        return SubjectFilter::apply($query, $filters);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_subject');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher');
    }
}
