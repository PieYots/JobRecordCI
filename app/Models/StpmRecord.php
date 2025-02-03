<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StpmRecord extends Model
{
    protected $table = 'stpm_records';

    protected $fillable = [
        'team_id',
        'is_team',
        'machine_id',
        'job_id',
        'file_ref',
        'is_finish',
        'e_training_id',
        'create_at',
        'record_by',
        'progress',
        'start_date',
        'end_date',
    ];

    // Relationships
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function eTraining()
    {
        return $this->belongsTo(ETraining::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(Employee::class, 'record_by');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'stpm_record_employee');
    }
}
