<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'azure_ad_object_id',
        'employee_id',
        'username',
        'role_id',
        'team_id',
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

    public function eTrainings(): BelongsToMany
    {
        return $this->belongsToMany(ETraining::class, 'e_training_user', 'user_id', 'e_training_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
