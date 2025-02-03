<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StpmRecord;
use Illuminate\Http\Request;

class StpmRecordController extends Controller
{
    public function store(Request $request)
    {

        $request->merge([
            'is_team' => filter_var($request->input('is_team'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            'is_finish' => filter_var($request->input('is_finish'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
        ]);

        // Validate incoming request
        $validatedData = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'is_team' => 'required|boolean',
            'machine_id' => 'required|exists:machines,id',
            'job_id' => 'required|exists:jobs,id',
            'file_ref' => 'nullable|file',
            'is_finish' => 'required|boolean',
            'e_training_id' => 'required|exists:e_trainings,id',
            'record_by' => 'required|exists:employees,id',
            'employees' => 'required|array', // List of employee IDs
            'employees.*' => 'exists:employees,id', // Ensure all employees exist
            'progress' => 'nullable|integer|between:0,100', // Add validation for progress
            'start_date' => 'required|date', // Validate startdate
            'end_date' => 'required|date|after_or_equal:startdate',
        ]);

        // Handle file upload if present
        $filePath = null;
        if ($request->hasFile('file_ref') && $request->file('file_ref')->isValid()) {
            $filePath = $request->file('file_ref')->store('stpm_files', 'public');
        }

        // Ensure boolean values are correctly converted
        $isTeam = (bool) $validatedData['is_team'];
        $isFinish = (bool) $validatedData['is_finish'];

        $progress = $validatedData['is_finish'] ? 100 : ($validatedData['progress'] ?? 0);

        // Create the STPM Record
        $stpmRecord = StpmRecord::create([
            'team_id' => $validatedData['team_id'],
            'is_team' => $isTeam,
            'machine_id' => $validatedData['machine_id'],
            'job_id' => $validatedData['job_id'],
            'file_ref' => $filePath ? 'storage/' . $filePath : null,
            'is_finish' => $isFinish,
            'e_training_id' => $validatedData['e_training_id'],
            'record_by' => $validatedData['record_by'],
            'progress' => $progress,
            'start_date' => $validatedData['start_date'], // Store startdate
            'end_date' => $validatedData['end_date'], // Store enddate
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
