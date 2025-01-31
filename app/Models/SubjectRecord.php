<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectRecord extends Model
{
    protected $table = 'subject_records';

    protected $fillable = [
        'topic',
        'type',
        'reference',
        'process',
        'result',
        'file_ref',
        'rating',
        'additional_learning',
        'e_training_id',
        'create_at',
        'record_by'
    ];

    // Relationships
    public function eTraining()
    {
        return $this->belongsTo(ETraining::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'record_by');
    }
}
