<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StpmRecord;
use Illuminate\Http\Request;

class StpmRecordController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'is_team' => 'required|boolean',
            'machine_id' => 'required|exists:machines,id',
            'job_id' => 'required|exists:jobs,id',
            'file_ref' => 'nullable|string',
            'is_finish' => 'required|boolean',
            'e_training_id' => 'required|exists:e_trainings,id',
            'record_by' => 'required|exists:employees,id',
            'employees' => 'required|array', // List of employee IDs
            'employees.*' => 'exists:employees,id', // Ensure all employees exist
            'progress' => 'nullable|integer|between:0,100', // Add validation for progress
        ]);

        $progress = $validatedData['is_finish'] ? 100 : ($validatedData['progress'] ?? 0);

        // Create the STPM Record
        $stpmRecord = StpmRecord::create([
            'team_id' => $validatedData['team_id'],
            'is_team' => $validatedData['is_team'],
            'machine_id' => $validatedData['machine_id'],
            'job_id' => $validatedData['job_id'],
            'file_ref' => $validatedData['file_ref'] ?? null,
            'is_finish' => $validatedData['is_finish'],
            'e_training_id' => $validatedData['e_training_id'],
            'record_by' => $validatedData['record_by'],
            'progress' => $progress,
            'create_at' => now(), // Manually setting the created_at timestamp
            'updated_at' => now(), // You may set this too if you want
        ]);

        // Attach employees to the STPM Record (many-to-many relation)
        $stpmRecord->employees()->attach($validatedData['employees']);

        return response()->json([
            'message' => 'STPM Record created successfully!',
            'data' => $stpmRecord->load('employees'),
        ], 200);
    }

    public function index()
    {
        $stpmRecords = StpmRecord::with('employees')->get();

        return response()->json([
            'message' => 'STPM Records fetched successfully!',
            'data' => $stpmRecords
        ]);
    }

    public function show($id)
    {
        $stpmRecord = StpmRecord::with('employees')->find($id);

        if (!$stpmRecord) {
            return response()->json([
                'message' => 'STPM Record not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'STPM Record fetched successfully!',
            'data' => $stpmRecord
        ]);
    }
}
