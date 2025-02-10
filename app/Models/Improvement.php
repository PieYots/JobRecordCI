<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'department_effect',  // Updated field name
        'rating',
        'additional_learning',
        'e_training_id',
    ];

    protected $casts = [
        'target_improvement' => 'string',  // No need for array, use string directly for enum
        'department_effect' => 'string',  // No need for array, use string directly for enum
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');  // Define relationship with Employee
    }

    public function eTraining()
    {
        return $this->belongsTo(ETraining::class);
    }
}
