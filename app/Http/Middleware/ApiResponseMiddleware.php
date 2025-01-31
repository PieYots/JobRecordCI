<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

class ApiResponseMiddleware
{
    /**
     * Handle an incoming request and wrap the response in a standard format.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Process the request and get the response
        $response = $next($request);

        // Check if the response is a JSON response
        if ($response instanceof JsonResponse) {
            // Extract existing data
            $originalData = $response->getData(true);

            // Wrap the response in the standardized format
            $response->setData([
                'status' => $response->status() === 200 ? 'success' : 'error',
                'code' => $response->status(),
                'message' => $originalData['message'] ?? ($response->status() === 200 ? 'Request successful' : 'An error occurred'),
                'data' => $originalData['data'] ?? $originalData
            ]);
        }

        return $response;
    }
}
