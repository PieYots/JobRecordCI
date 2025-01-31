<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $table = 'machines';

    protected $fillable = ['machine_name'];

    // Relationships
    public function stpmRecords()
    {
        return $this->hasMany(StpmRecord::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
