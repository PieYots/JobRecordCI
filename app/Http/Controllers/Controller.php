<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}

class HelloController
{
    use ApiResponseTrait;
    public function hello()
    {
        $data = [
            'message' => 'Hello, World!',
        ];

        // Use the helper to return a standardized response
        return $this->apiResponse($data, 'API call successful', 200, true);
    }
}
