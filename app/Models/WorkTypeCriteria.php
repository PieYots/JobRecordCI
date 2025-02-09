<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkTypeCriteria extends Model
{
    use HasFactory;

    protected $fillable = ['work_type_id', 'name'];

    public function workType()
    {
        return $this->belongsTo(WorkType::class);
    }
}
