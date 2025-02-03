<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectRecord extends Model
{
    protected $table = 'subject_records';

    protected $fillable = [
        'topic',
        'course_type_id',
        'reference',
        'process',
        'result',
        'file_ref',
        'rating',
        'additional_learning',
        'e_training_id',
        'create_at',
        'record_by',
        'start_date',
        'end_date'
    ];

    // Relationships
    public function eTraining()
    {
        return $this->belongsTo(ETraining::class);
    }

    public function recordBy()
    {
        return $this->belongsTo(Employee::class, 'record_by');
    }

    public function courseType()
    {
        return $this->belongsTo(CourseType::class, 'course_type_id');
    }
}
