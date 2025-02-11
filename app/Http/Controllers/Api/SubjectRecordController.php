<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubjectRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubjectRecordController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'topic' => 'nullable|string',
            'course_type_id' => 'nullable|exists:course_types,id', // Foreign key constraint
            // 'reference' => 'nullable|string',
            'process' => 'nullable|string',
            'result' => 'nullable|string',
            'file_ref' => 'nullable|file',
            'rating' => 'nullable|integer|between:1,5', // Rating as integer
            'additional_learning' => 'nullable|string',
            'ojt_record_id' => 'nullable|exists:ojt_records,id',
            'e_training_id' => 'nullable|exists:e_trainings,id',
            'record_by' => 'nullable|exists:employees,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Handle file upload if present
        $filePath = null;
        if ($request->hasFile('file_ref') && $request->file('file_ref')->isValid()) {
            $filePath = $request->file('file_ref')->store('subject_files', 'public');
        }

        // Create the Subject Record
        $subjectRecord = SubjectRecord::create([
            'topic' => $validatedData['topic'],
            'course_type_id' => $validatedData['course_type_id'],
            // 'reference' => $validatedData['reference'],
            'process' => $validatedData['process'],
            'result' => $validatedData['result'],
            'file_ref' => $filePath ? 'storage/' . $filePath : null,
            'rating' => $validatedData['rating'],
            'additional_learning' => $validatedData['additional_learning'],
            'ojt_record_id' => $validatedData['ojt_record_id'],
            'e_training_id' => $validatedData['e_training_id'],
            'recorded_by' => $validatedData['record_by'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'created_at' => now(),
        ]);

        return response()->json([
            'message' => 'Subject Record created successfully!',
            'data' => $subjectRecord
        ], 200);
    }

    public function index()
    {
        $subjectRecords = SubjectRecord::with('courseType', 'eTraining', 'recordBy')->get();

        return response()->json([
            'message' => 'Subject Records fetched successfully!',
            'data' => $subjectRecords
        ]);
    }

    public function show($id)
    {
        $subjectRecord = SubjectRecord::with('courseType', 'eTraining', 'recordBy')->find($id);

        if (!$subjectRecord) {
            return response()->json([
                'message' => 'Subject Record not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Subject Record fetched successfully!',
            'data' => $subjectRecord
        ]);
    }

    public function destroy($id)
    {
        $subjectRecord = SubjectRecord::find($id);

        if (!$subjectRecord) {
            return response()->json([
                'message' => 'Subject Record not found',
            ], 404);
        }

        // If there's a related file, you can also delete it from storage
        if ($subjectRecord->file_ref) {
            // Delete the file from public storage
            Storage::disk('public')->delete(str_replace('storage/', '', $subjectRecord->file_ref));
        }

        // Delete the Subject Record
        $subjectRecord->delete();

        return response()->json([
            'message' => 'Subject Record deleted successfully',
        ], 200);
    }
}
