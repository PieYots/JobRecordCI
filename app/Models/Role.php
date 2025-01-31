<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'role_name', 
        'status'
    ];

    // Relationships
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
