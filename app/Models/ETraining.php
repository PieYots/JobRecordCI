<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ETraining extends Model
{
    protected $table = 'e_trainings';

    protected $fillable = ['e_training_name'];

    // Relationships
    public function stpmRecords()
    {
        return $this->hasMany(StpmRecord::class);
    }

    public function subjectRecords()
    {
        return $this->hasMany(SubjectRecord::class);
    }
}
