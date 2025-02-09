<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitiveRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'topic',
        'stpm_record_id',
        'work_type',
        'work_type_criteria',
        'file_ref',
        'result',
    ];

    public function stpmRecord()
    {
        return $this->belongsTo(StpmRecord::class);
    }
}
