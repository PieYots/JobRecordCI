<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'azure_ad_object_id', 
        'employee_id', 
        'username', 
        'role_id', 
        'status'
    ];

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function tokens()
    {
        return $this->hasMany(Token::class);
    }
}
