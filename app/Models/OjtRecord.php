<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OjtRecord extends Model
{
    use HasFactory;

    protected $table = 'ojt_records';

    protected $fillable = [
        'employee_id',
        'type',
        'topic',
        'start_date',
        'end_date',
        'hour',
        'detail',
        'file_ref',
        'instructor_name',
        'external_institution',
        'learner_name',
        'comment',
    ];

    /**
     * Relationship: OJT record belongs to an employee.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
