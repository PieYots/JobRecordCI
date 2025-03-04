<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Improvement extends Model
{
    use HasFactory;

    protected $table = 'improvements';

    protected $fillable = [
        'employee_id',
        'type',
        'topic',
        'start_date',
        'end_date',
        'previous_working',
        'new_working',
        'file_ref',
        'target_improvement',
        'result',
        'ctl_reduction',
        'department_effect',
        'rating',
        'additional_learning',
        'e_training_id',
        'reference_stpm_id',
        'reference_course_id',
        'status',
        'support_strategy',
    ];

    protected $attributes = [
        'status' => 'waiting', // Default status
    ];

    // Relationships

    // Relationship with the employee who created the Improvement
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // Relationship with ETraining (optional)
    public function eTraining()
    {
        return $this->belongsTo(ETraining::class, 'e_training_id');
    }

    // Relationship with STPM records
    public function stpmRecord()
    {
        return $this->belongsTo(StpmRecord::class, 'reference_stpm_id');
    }

    // Relationship with Course records
    public function courseRecord()
    {
        return $this->belongsTo(SubjectRecord::class, 'reference_course_id');
    }

    // Scopes

    // Scope to filter improvements by status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Accessors

    // Accessor for file_ref to return the full URL
    public function getFileRefUrlAttribute()
    {
        if ($this->file_ref) {
            return asset('storage/' . $this->file_ref);
        }
        return null;
    }
}
