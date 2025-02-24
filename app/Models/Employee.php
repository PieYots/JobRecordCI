<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'employee_name',
        'email',
        'department',
        'team_id',
        'score'
    ];

    // Relationships
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function stpmRecords()
    {
        return $this->belongsToMany(StpmRecord::class, 'stpm_record_employee');
    }

    public function subjectRecords()
    {
        return $this->belongsToMany(SubjectRecord::class, 'subject_record');
    }
}
