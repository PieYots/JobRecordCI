<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ScoreHelper;
use App\Http\Controllers\Controller;
use App\Models\OjtRecord;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class OjtRecordController extends Controller
{
    // Get all OJT records
    public function index(): JsonResponse
    {
        $ojtRecords = OjtRecord::with('employee')->get();

        return response()->json([
            'message' => 'OJT Records fetched successfully!',
            'data' => $ojtRecords
        ]);
    }

    // Get a single OJT record by ID
    public function show($id): JsonResponse
    {
        $ojtRecord = OjtRecord::with('employee')->find($id);

        if (!$ojtRecord) {
            return response()->json([
                'message' => 'OJT Record not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'OJT Record fetched successfully!',
            'data' => $ojtRecord
        ]);
    }

    // Create a new OJT record
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|in:learner,instructor',
            'type_of_instruction' => 'nullable|in:Daily Job,Breakdown Job,New PMP,Other',
            'topic' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'hour' => 'nullable|integer',
            'detail' => 'nullable|string',
            'file_ref' => 'nullable|file',
            'instructor_name' => 'nullable|string', // Only for learner type
            'external_institution' => 'nullable|string', // Only for learner type
            'learner_name' => 'nullable|string', // Only for instructor type
            'comment' => 'nullable|string', // Only for instructor type
        ]);

        // Handle file upload if present
        $filePath = null;
        if ($request->hasFile('file_ref') && $request->file('file_ref')->isValid()) {
            $filePath = $request->file('file_ref')->store('ojt_files', 'public');
        }

        // Create the OJT Record
        $ojtRecord = OjtRecord::create([
            'employee_id' => $validatedData['employee_id'],
            'type' => $validatedData['type'],
            'type_of_instruction' => $validatedData['type_of_instruction'] ?? null,
            'topic' => $validatedData['topic'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'hour' => $validatedData['hour'],
            'detail' => $validatedData['detail'],
            'file_ref' => $filePath ? 'storage/' . $filePath : null,
            'instructor_name' => $validatedData['instructor_name'],
            'external_institution' => $validatedData['external_institution'],
            'learner_name' => $validatedData['learner_name'],
            'comment' => $validatedData['comment'],
        ]);

        ScoreHelper::fillEmployeeByCriteria($validatedData['employee_id'], 7);

        return response()->json([
            'message' => 'OJT Record created successfully!',
            'data' => $ojtRecord
        ], 201);
    }

    // Delete an OJT record
    public function destroy($id): JsonResponse
    {
        $ojtRecord = OjtRecord::find($id);

        if (!$ojtRecord) {
            return response()->json([
                'message' => 'OJT Record not found',
                'data' => null
            ], 404);
        }

        // Delete the file if it exists
        if ($ojtRecord->file_ref) {
            Storage::delete($ojtRecord->file_ref);
        }

        $ojtRecord->delete();

        return response()->json([
            'message' => 'OJT Record deleted successfully!',
        ], 200);
    }
}
