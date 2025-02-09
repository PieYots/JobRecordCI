<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkType;
use Illuminate\Http\Request;

class WorkTypeController extends Controller
{
    public function index()
    {
        $workTypes = WorkType::with('criteria')->get();
        return response()->json(['message' => 'Work types fetched successfully!', 'data' => $workTypes]);
    }

    public function show($id)
    {
        $workType = WorkType::with('criteria')->find($id);
        if (!$workType) {
            return response()->json(['message' => 'Work type not found'], 404);
        }
        return response()->json(['message' => 'Work type fetched successfully!', 'data' => $workType]);
    }
}
