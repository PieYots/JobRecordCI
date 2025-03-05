<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Token;
use Carbon\Carbon;

class AuthTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Verify token in database
        $hashedToken = hash('sha256', $token);
        $tokenRecord = Token::where('access_token', $hashedToken)
            ->where('access_expire_at', '>', now())
            ->first();

        if (!$tokenRecord) {
            return response()->json(['error' => 'Token expired or invalid'], 401);
        }

        // Attach user to request
        $request->merge(['user' => $tokenRecord->user]);

        return $next($request);
    }
}
