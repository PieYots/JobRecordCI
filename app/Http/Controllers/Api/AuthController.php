<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Token;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Find user by email from the employee relation
        $user = User::whereHas('employee', function ($query) use ($request) {
            $query->where('email', $request->email);
        })->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Generate a new token
        $tokenString = Str::random(60);
        $hashedToken = hash('sha256', $tokenString); // Store hashed version for security

        $token = Token::create([
            'user_id' => $user->id,
            'access_token' => $hashedToken,
            'access_created_at' => now(),
            'access_expire_at' => now()->addHours(2), // Token expires in 2 hours
        ]);

        return response()->json([
            'token' => $tokenString, // Return the plain token to the user
            'expires_at' => $token->access_expire_at,
            'user' => $user,
        ]);
    }
}
