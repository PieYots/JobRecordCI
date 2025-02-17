<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OPL extends Model
{
    use HasFactory;

    protected $table = 'opls';

    protected $fillable = [
        'type',
        'employee_id',
        'topic',
        'description',
        'file_ref',
        'result',
        'e_training_id',
        'reference_stpm_id',
        'reference_course_id',
        'status',
    ];

    protected $attributes = [
        'status' => 'waiting', // Default status
    ];

    /**
     * Relationship with the employee who created the OPL.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Relationship with ETraining.
     */
    public function eTraining()
    {
        return $this->belongsTo(ETraining::class, 'e_training_id');
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
     * Many-to-Many relationship with employees (who are taught via OPL).
     */
    public function taughtEmployees()
    {
        return $this->belongsToMany(Employee::class, 'opl_employee', 'opl_id', 'employee_id')->withTimestamps();
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
     * Scope to filter OPLs by status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter OPLs by type.
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to filter OPLs by employee.
     */
    public function scopeEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }
}
