<?php

namespace App\Models;

use App\Filters\CourseFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Course extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'description',
        'duration',
    ];

    public function scopeFiltered(Builder $query, array $filters): Builder
    {
        return CourseFilter::apply($query, $filters);
    }

    public function classes()
    {
        return $this->hasMany(SchoolClass::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
