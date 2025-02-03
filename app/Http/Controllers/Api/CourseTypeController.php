<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourseType;
use Illuminate\Http\Request;

class CourseTypeController extends Controller
{
    // GET all course types
    public function index()
    {
        $courseTypes = CourseType::all();

        return response()->json([
            'message' => 'Course types fetched successfully!',
            'data' => $courseTypes,
        ], 200);
    }
}
