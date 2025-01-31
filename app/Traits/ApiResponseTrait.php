<?php

namespace App\Traits;

trait ApiResponseTrait
{
    /**
     * Standard API response format
     *
     * @param mixed  $data
     * @param string $message
     * @param int    $code
     * @param bool   $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiResponse($data = null, $message = 'Success', $code = 200, $status = true)
    {
        return response()->json([
            'status'  => $status,
            'code'    => $code,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }
}
