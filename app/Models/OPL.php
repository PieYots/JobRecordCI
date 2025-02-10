<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $casts = [
        'teach_employees' => 'array', // Store JSON as array (you may remove this if pivot is used)
    ];

    // Relationship with the employee who created the OPL
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // Relationship with ETraining (optional)
    public function eTraining()
    {
        return $this->belongsTo(ETraining::class);
    }

    // Define the many-to-many relationship with Employee via the pivot table
    public function teachEmployees()
    {
        return $this->belongsToMany(Employee::class, 'opl_employee', 'opl_id', 'employee_id');
    }
}
