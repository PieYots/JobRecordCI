<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';

    protected $fillable = ['team_name'];

    // Relationships
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function stpmRecords()
    {
        return $this->hasMany(StpmRecord::class);
    }
}
