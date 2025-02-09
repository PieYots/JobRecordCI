<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkType extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'name', 'has_criteria'];

    public function criteria()
    {
        return $this->hasMany(WorkTypeCriteria::class);
    }
}
