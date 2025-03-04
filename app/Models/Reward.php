<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'reward_name',
        'reward_image',
        'reward_detail',
        'reward_point',
        'reward_left',
    ];
}
