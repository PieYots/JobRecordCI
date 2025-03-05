<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'tokens'; // Define table name

    protected $fillable = [
        'user_id',
        'access_token',
        'access_created_at',
        'access_expire_at',
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
