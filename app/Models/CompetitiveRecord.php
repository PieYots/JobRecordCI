<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CompetitiveRecord extends Model
{
    use HasFactory;

    protected $table = 'competitive_records';

    protected $fillable = [
        'type',
        'topic',
        'employee_id',
        'work_type',
        'work_type_criteria',
        'file_ref',
        'result',
        'reference_stpm_id',
        'reference_course_id',
        'reference_opls_id',
        'reference_improvement_id',
        'status',
        'competitive_name',
    ];

    protected $attributes = [
        'status' => 'waiting', // Default status
    ];

    /**
     * Relationship with the employee who created the record.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Relationship with STPM records.
     */
    public function stpmRecord()
    {
        return $this->belongsTo(StpmRecord::class, 'reference_stpm_id');
    }

    /**
     * Relationship with Course records.
     */
    public function courseRecord()
    {
        return $this->belongsTo(SubjectRecord::class, 'reference_course_id');
    }

    /**
     * Relationship with OPL records.
     */
    public function oplRecord()
    {
        return $this->belongsTo(OPL::class, 'reference_opls_id');
    }

    /**
     * Relationship with Improvement records.
     */
    public function improvementRecord()
    {
        return $this->belongsTo(Improvement::class, 'reference_improvement_id');
    }

    /**
     * Accessor for file_ref to return the full URL.
     */
    public function getFileRefUrlAttribute()
    {
        if ($this->file_ref) {
            return asset('storage/' . $this->file_ref);
        }
        return null;
    }

    /**
     * Scope to filter records by status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter records by type.
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to filter records by employee.
     */
    public function scopeEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    /**
     * Scope to filter records by work type.
     */
    public function scopeWorkType($query, $workType)
    {
        return $query->where('work_type', $workType);
    }
}
