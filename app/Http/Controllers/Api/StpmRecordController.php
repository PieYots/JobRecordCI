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
        // Convert boolean values correctly
        $request->merge([
            'is_team' => filter_var($request->input('is_team'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            'is_finish' => filter_var($request->input('is_finish'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
        ]);

        // Manually parse Form-Data employees array
        $employees = [];
        if ($request->has('employees')) {
            foreach ($request->input('employees') as $key => $employee) {
                $employees[] = [
                    'employee_id' => $employee['employee_id'] ?? null,
                    'ojt_record_id' => $employee['ojt_record_id'] ?? null,
                    'e_training_id' => $employee['e_training_id'] ?? null,
                ];
            }
        }

        // Validate incoming request
        $validatedData = $request->validate([
            'team_id' => 'nullable|exists:teams,id',
            'is_team' => 'required|boolean',
            'machine_id' => 'nullable|exists:machines,id',
            'job_id' => 'nullable|exists:jobs,id',
            'file_ref' => 'nullable|file',
            'is_finish' => 'required|boolean',
            'record_by' => 'nullable|exists:employees,id',
            'progress' => 'nullable|integer|between:0,100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'employees.*.employee_id' => 'nullable|exists:employees,id',
            'employees.*.ojt_record_id' => 'nullable|exists:ojt_records,id',
            'employees.*.e_training_id' => 'nullable|exists:e_trainings,id',
        ]);

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('file_ref') && $request->file('file_ref')->isValid()) {
            $filePath = $request->file('file_ref')->store('stpm_files', 'public');
        }

        // Convert is_team and is_finish to boolean
        $isTeam = (bool) $validatedData['is_team'];
        $isFinish = (bool) $validatedData['is_finish'];
        $progress = $isFinish ? 100 : ($validatedData['progress'] ?? 0);

        // Create STPM Record
        $stpmRecord = StpmRecord::create([
            'team_id' => $validatedData['team_id'],
            'is_team' => $isTeam,
            'machine_id' => $validatedData['machine_id'],
            'job_id' => $validatedData['job_id'],
            'file_ref' => $filePath ? 'storage/' . $filePath : null,
            'is_finish' => $isFinish,
            'recorded_by' => $validatedData['record_by'],
            'progress' => $progress,
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
        ]);

        // Attach employees
        if (!empty($employees)) {
            foreach ($employees as $employeeData) {
                $stpmRecord->employees()->attach($employeeData['employee_id'], [
                    'ojt_record_id' => $employeeData['ojt_record_id'] ?? null,
                    'e_training_id' => $employeeData['e_training_id'] ?? null,
                ]);
            }
        }

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

    public function setOjtAndETraining(Request $request, $id)
    {
        $stpmRecord = StpmRecord::find($id);

        if (!$stpmRecord) {
            return response()->json(['message' => 'STPM Record not found'], 404);
        }

        // Validate request
        $validatedData = $request->validate([
            'employees' => 'required|array',
            'employees.*.employee_id' => 'required|exists:employees,id',
            'employees.*.ojt_record_id' => 'nullable|exists:ojt_records,id',
            'employees.*.e_training_id' => 'nullable|exists:e_trainings,id',
        ]);

        // Sync employees with new OJT and E-Training records
        $syncData = [];
        foreach ($validatedData['employees'] as $employeeData) {
            $syncData[$employeeData['employee_id']] = [
                'ojt_record_id' => $employeeData['ojt_record_id'] ?? null,
                'e_training_id' => $employeeData['e_training_id'] ?? null,
            ];
        }

        // Sync many-to-many relationship
        $stpmRecord->employees()->sync($syncData);

        return response()->json([
            'message' => 'OJT and E-Training records updated successfully!',
            'data' => $stpmRecord->load('employees'),
        ], 200);
    }
}
