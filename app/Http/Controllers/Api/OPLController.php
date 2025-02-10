<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OPL;
use App\Models\Employee; // To validate employee existence
use Illuminate\Http\Request;

class OPLController extends Controller
{
    public function index()
    {
        // Get all OPL records and load the teach_employees relationship
        return response()->json(OPL::with('teachEmployees')->get(), 200);
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
        ]);

        // Attach teach_employees to the OPL (many-to-many relationship via the pivot table)
        if ($request->has('teach_employees') && count($request->teach_employees) > 0) {
            $opl->teachEmployees()->attach($request->teach_employees);
        }

        // Return response with the created OPL and associated teach_employees
        return response()->json([
            'message' => 'OPL created successfully',
            'data' => $opl->load('teachEmployees') // Eager load teachEmployees relationship
        ], 201);
    }


    public function show($id)
    {
        // Find and return the OPL with the associated teach_employees
        $opl = OPL::with('teachEmployees')->findOrFail($id);
        return response()->json($opl, 200);
    }

    public function destroy($id)
    {
        // Find the OPL and delete it
        OPL::destroy($id);
        return response()->json(['message' => 'OPL deleted successfully'], 200);
    }
}
