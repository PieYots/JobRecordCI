<?php

namespace App\Http\Controllers\Api;

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
        $records = CompetitiveRecord::all();
        return response()->json(['message' => 'Competitive records fetched successfully!', 'data' => $records]);
    }

    public function show($id)
    {
        $record = CompetitiveRecord::find($id);

        if (!$record) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        return response()->json(['message' => 'Record fetched successfully!', 'data' => $record]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|in:Kaizen,OE',
            'topic' => 'required|string|max:255',
            'stpm_record_id' => 'nullable|exists:stpm_records,id',
            'work_type_id' => 'required|exists:work_types,id',
            'work_type_criteria_id' => 'nullable|exists:work_type_criterias,id',
            'file_ref' => 'nullable|file',
            'result' => 'nullable|string',
        ]);

        $workType = WorkType::find($validatedData['work_type_id']);

        if ($validatedData['type'] === 'Kaizen' && $workType->has_criteria && !$validatedData['work_type_criteria_id']) {
            return response()->json(['message' => 'Work type criteria is required for this work type'], 400);
        }

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('file_ref') && $request->file('file_ref')->isValid()) {
            $filePath = $request->file('file_ref')->store('competitive_files', 'public');
        }

        $record = CompetitiveRecord::create([
            'type' => $validatedData['type'],
            'topic' => $validatedData['topic'],
            'stpm_record_id' => $validatedData['stpm_record_id'],
            'work_type' => $workType->name,
            'work_type_criteria' => $validatedData['work_type_criteria_id'] ? WorkTypeCriteria::find($validatedData['work_type_criteria_id'])->name : null,
            'file_ref' => $filePath ? 'storage/' . $filePath : null,
            'result' => $validatedData['result'],
        ]);

        return response()->json(['message' => 'Competitive record created successfully!', 'data' => $record]);
    }


    public function destroy($id)
    {
        $record = CompetitiveRecord::find($id);

        if (!$record) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        if ($record->file_ref) {
            Storage::disk('public')->delete(str_replace('storage/', '', $record->file_ref));
        }

        $record->delete();

        return response()->json(['message' => 'Record deleted successfully']);
    }
}
