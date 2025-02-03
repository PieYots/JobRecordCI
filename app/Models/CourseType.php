<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseType extends Model
{
    use HasFactory;

    protected $table = 'course_types';

    protected $fillable = [
        'course_name',
    ];

    // Relationship: One course type has many course records
    public function courseRecords()
    {
        return $this->hasMany(SubjectRecord::class, 'course_type_id');
    }
}
