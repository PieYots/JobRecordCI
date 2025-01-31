<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs';

    protected $fillable = [
        'job_name', 
        'machine_id'
    ];

    // Relationships
    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function stpmRecords()
    {
        return $this->hasMany(StpmRecord::class);
    }
}
