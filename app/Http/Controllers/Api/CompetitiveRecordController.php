<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ScoreHelper;
use App\Http\Controllers\Controller;
use App\Models\CompetitiveRecord;
use App\Models\WorkType;
use App\Models\WorkTypeCriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompetitiveRecordController extends Controller
{
    public function index()
    {
        // Fetch all competitive records with pagination
        $records = CompetitiveRecord::all();
        return response()->json([
            'message' => 'Competitive records fetched successfully!',
            'data' => $records,
        ]);
    }

    public function show($id)
    {
        // Find the record by ID or return a 404 error
        $record = CompetitiveRecord::find($id);

        if (!$record) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        return response()->json([
            'message' => 'Record fetched successfully!',
            'data' => $record,
        ]);
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'type' => 'required|in:Kaizen,OE',
            'topic' => 'required|string|max:255',
            'employee_id' => 'nullable|exists:employees,id',
            'stpm_record_id' => 'nullable|exists:stpm_records,id',
            'work_type_id' => 'required|exists:work_types,id',
            'work_type_criteria_id' => 'nullable|exists:work_type_criterias,id',
            'file_ref' => 'nullable|file|mimes:pdf,doc,docx,mp4,mov,avi|max:20480', // 20MB max
            'result' => 'nullable|numeric',
            'reference_course_id' => 'nullable|exists:subject_records,id',
            'reference_opls_id' => 'nullable|exists:opls,id',
            'reference_improvement_id' => 'nullable|exists:improvements,id',
            'competitive_name' => 'nullable|string|max:255',
        ]);

        // Fetch the work type
        $workType = WorkType::find($validatedData['work_type_id']);

        // Validate work type criteria for Kaizen type
        if ($validatedData['type'] === 'Kaizen' && $workType->has_criteria && !$validatedData['work_type_criteria_id']) {
            return response()->json([
                'message' => 'Work type criteria is required for this work type',
            ], 400);
        }

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('file_ref') && $request->file('file_ref')->isValid()) {
            $filePath = $request->file('file_ref')->store('competitive_files', 'public');
        }

        // Create the competitive record
        $record = CompetitiveRecord::create([
            'type' => $validatedData['type'],
            'topic' => $validatedData['topic'],
            'employee_id' => $validatedData['employee_id'],
            'work_type' => $workType->name,
            'work_type_criteria' => $validatedData['work_type_criteria_id']
                ? WorkTypeCriteria::find($validatedData['work_type_criteria_id'])->name
                : null,
            'file_ref' => $filePath,
            'result' => $validatedData['result'],
            'reference_stpm_id' => $validatedData['stpm_record_id'],
            'reference_course_id' => $validatedData['reference_course_id'],
            'reference_opls_id' => $validatedData['reference_opls_id'],
            'reference_improvement_id' => $validatedData['reference_improvement_id'],
            'competitive_name' => $validatedData['competitive_name'],
        ]);

        return response()->json([
            'message' => 'Competitive record created successfully!',
            'data' => $record,
        ], 201);
    }

    public function updateProgress(Request $request)
    {
        // Validate request data (including the necessary fields)
        $validatedData = $request->validate([
            'id' => 'required|exists:competitive_records,id', // The ID of the competitive record
            'status' => 'required|in:ongoing,eliminated,qualify',
            'next_competitive' => 'nullable|string', // For the next competitive record
            'point' => 'nullable|numeric', // For the points
        ]);

        // Find the competitive record by ID
        $record = CompetitiveRecord::findOrFail($validatedData['id']);

        // Update the record with new data
        $record->status = $validatedData['status'];
        $record->competitive_name = $validatedData['next_competitive'];
        // $record->point = $validatedData['point'] ?? $record->point; // Update point if provided

        if ($record->status == 'qualify' || $record->status == 'eliminated') {
            ScoreHelper::addEmployeeScore($record->employee_id, $validatedData['point']);
            ScoreHelper::addCompetitiveScore($validatedData['id'], $validatedData['point']);
        }

        $record->save(); // Save changes

        $UpdateRecord = CompetitiveRecord::findOrFail($validatedData['id']);

        // Return a response with the updated record data
        return response()->json([
            'message' => 'Competitive record progress updated successfully!',
            'data' => $UpdateRecord
        ]);
    }



    public function destroy($id)
    {
        // Find the record by ID or return a 404 error
        $record = CompetitiveRecord::find($id);

        if (!$record) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        // Delete the associated file if it exists
        if ($record->file_ref && Storage::disk('public')->exists($record->file_ref)) {
            Storage::disk('public')->delete($record->file_ref);
        }

        // Delete the record
        $record->delete();

        return response()->json([
            'message' => 'Record deleted successfully',
        ]);
    }
}
