<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportStrategy extends Model
{
    use HasFactory;

    protected $table = 'support_strategy'; // Explicitly defining the table name

    protected $fillable = [
        'support_strategy',
    ];
}
