<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StpmRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'team_id' => 'nullable|exists:teams,id',
            'is_team' => 'required|boolean',
            'machine_id' => 'nullable|exists:machines,id',
            'job_id' => 'nullable|exists:jobs,id',
            'file_ref' => 'nullable|file',
            'is_finish' => 'required|boolean',
            'ojt_record_id' => 'nullable|exists:ojt_records,id',
            'e_training_id' => 'nullable|exists:e_trainings,id',
            'record_by' => 'nullable|exists:employees,id',
            'employees' => 'nullable|array', // List of employee IDs
            'employees.*' => 'nullable|exists:employees,id', // Ensure all employees exist
            'progress' => 'nullable|integer|between:0,100', // Add validation for progress
            'start_date' => 'nullable|date', // Validate startdate
            'end_date' => 'nullable|date|after_or_equal:startdate',
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
            'ojt_record_id' => $validatedData['ojt_record_id'],
            'e_training_id' => $validatedData['e_training_id'],
            'recorded_by' => $validatedData['record_by'],
            'progress' => $progress,
            'start_date' => $validatedData['start_date'], // Store startdate
            'end_date' => $validatedData['end_date'], // Store enddate
            'created_at' => now(), // Manually setting the created_at timestamp
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

    public function destroy($id)
    {
        $stpmRecord = StpmRecord::find($id);

        if (!$stpmRecord) {
            return response()->json([
                'message' => 'STPM Record not found',
            ], 404);
        }

        if ($stpmRecord->file_ref) {
            // Delete the file from public storage
            Storage::disk('public')->delete(str_replace('storage/', '', $stpmRecord->file_ref));
        }

        // Delete the STPM Record, which will also delete entries in the pivot table (many-to-many)
        $stpmRecord->employees()->detach(); // Detach employees before deletion
        $stpmRecord->delete();

        return response()->json([
            'message' => 'STPM Record deleted successfully',
        ], 200);
    }
}
