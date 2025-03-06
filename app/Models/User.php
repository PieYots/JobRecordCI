<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

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

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function generateToken()
    {
        $token = Str::random(60);

        $this->tokens()->create([
            'access_token' => hash('sha256', $token),
            'access_created_at' => now(),
            'access_expire_at' => now()->addHours(2),
        ]);

        return $token;
    }
}
