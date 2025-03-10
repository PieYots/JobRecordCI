<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreCriteria extends Model
{
    use HasFactory;

    protected $table = 'score_criteria';

    protected $fillable = [
        'score',
        'description'
    ];
}
