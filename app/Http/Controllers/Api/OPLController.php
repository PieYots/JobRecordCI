<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OPL;
use App\Helpers\ScoreHelper;
use Illuminate\Http\Request;

class OPLController extends Controller
{
    public function index()
    {
        // Get all OPL records and load the taughtEmployees relationship
        return response()->json(OPL::with('taughtEmployees')->get(), 200);
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'type' => 'required|in:paper,video',
            'employee_id' => 'required|exists:employees,id',
            'topic' => 'required|string',
            'description' => 'nullable|string',
            'file_ref' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg,mp4|max:10240',
            'result' => 'nullable|string',
            'teach_employees' => 'nullable|array',
            'teach_employees.*' => 'exists:employees,id',
            'e_training_id' => 'nullable|exists:e_trainings,id',
            'reference_stpm_id' => 'nullable|exists:stpm_records,id', // Add validation for reference_stpm_id
            'reference_course_id' => 'nullable|exists:subject_records,id', // Add validation for reference_course_id
        ]);

        // Handle file upload if present
        $filePath = null;
        if ($request->hasFile('file_ref') && $request->file('file_ref')->isValid()) {
            $filePath = $request->file('file_ref')->store('opl_files', 'public');
        }

        // Create OPL record
        $opl = OPL::create([
            'type' => $request->type,
            'employee_id' => $request->employee_id,
            'topic' => $request->topic,
            'description' => $request->description,
            'file_ref' => $filePath,
            'result' => $request->result,
            'e_training_id' => $request->e_training_id,
            'reference_stpm_id' => $request->reference_stpm_id, // Add reference_stpm_id
            'reference_course_id' => $request->reference_course_id, // Add reference_course_id
        ]);

        // Attach teach_employees to the OPL (many-to-many relationship via the pivot table)
        if ($request->has('teach_employees') && count($request->teach_employees) > 0) {
            $opl->taughtEmployees()->attach($request->teach_employees);
        }

        // Return response with the created OPL and associated teach_employees
        return response()->json([
            'message' => 'OPL created successfully',
            'data' => $opl->load('taughtEmployees') // Eager load taughtEmployees relationship
        ], 201);
    }

    public function show($id)
    {
        // Find and return the OPL with the associated teach_employees
        $opl = OPL::with('taughtEmployees')->findOrFail($id);
        return response()->json($opl, 200);
    }

    public function destroy($id)
    {
        // Find the OPL and delete it
        OPL::destroy($id);
        return response()->json(['message' => 'OPL deleted successfully'], 200);
    }
}
