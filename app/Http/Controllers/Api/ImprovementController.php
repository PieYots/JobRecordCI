<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Improvement;
use Illuminate\Http\Request;

class ImprovementController extends Controller
{
    public function index()
    {
        return response()->json(Improvement::all(), 200);
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'employee_id' => 'nullable|exists:employees,id', // Ensure the employee exists
            'type' => 'nullable|in:paper,video',
            'topic' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'previous_working' => 'nullable|string',
            'new_working' => 'nullable|string',
            'file_ref' => 'nullable|file',
            'target_improvement' => 'nullable|in:speed,accuracy,efficiency',  // Validate enum for target_improvement
            'result' => 'nullable|string',
            'ctl_reduction' => 'nullable|integer',
            'department_effect' => 'nullable|in:HR,Engineering,Marketing,Sales,Customer Support',  // Validate enum for department_effect
            'rating' => 'nullable|integer|between:1,5',
            'additional_learning' => 'nullable|string',
            'e_training_id' => 'nullable|exists:e_trainings,id',
        ]);

        // Handle file upload if present
        $filePath = null;
        if ($request->hasFile('file_ref') && $request->file('file_ref')->isValid()) {
            $filePath = $request->file('file_ref')->store('improvement_files', 'public');
        }

        // Create Improvement record
        $improvement = Improvement::create([
            'employee_id' => $request->employee_id,  // Set the recorder's employee ID
            'type' => $request->type,
            'topic' => $request->topic,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'previous_working' => $request->previous_working,
            'new_working' => $request->new_working,
            'file_ref' => $filePath,
            'target_improvement' => $request->target_improvement,
            'result' => $request->result,
            'ctl_reduction' => $request->ctl_reduction,
            'department_effect' => $request->department_effect,
            'rating' => $request->rating,
            'additional_learning' => $request->additional_learning,
            'e_training_id' => $request->e_training_id,
        ]);

        // Return response with the created Improvement
        return response()->json([
            'message' => 'Improvement created successfully',
            'data' => $improvement,
        ], 201);
    }

    public function show($id)
    {
        return response()->json(Improvement::findOrFail($id), 200);
    }

    public function destroy($id)
    {
        Improvement::destroy($id);
        return response()->json(['message' => 'Improvement deleted successfully'], 200);
    }
}
