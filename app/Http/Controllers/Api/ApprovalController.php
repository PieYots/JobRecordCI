<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StpmRecord;
use App\Models\SubjectRecord;
use Illuminate\Http\JsonResponse;

class ApprovalController extends Controller
{
    // API to approve a StpmRecord
    public function approveStpmRecord(Request $request): JsonResponse
    {
        // Validate the incoming request
        $validated = $request->validate([
            'id' => 'required|integer',
            'status' => 'required|in:waiting,pass,fail',
        ]);

        // Find the StpmRecord by ID
        $record = StpmRecord::find($validated['id']);

        // Check if the record exists
        if (!$record) {
            return response()->json(['message' => 'Stpm Record not found'], 404);
        }

        // Update the status of the StpmRecord
        $record->status = $validated['status'];
        $record->save();

        // Return success response with the updated record
        return response()->json(['message' => 'Stpm Record updated successfully', 'record' => $record]);
    }

    // API to approve a SubjectRecord
    public function approveSubjectRecord(Request $request): JsonResponse
    {
        // Validate the incoming request
        $validated = $request->validate([
            'id' => 'required|integer',
            'status' => 'required|in:waiting,pass,fail',
        ]);

        // Find the SubjectRecord by ID
        $record = SubjectRecord::find($validated['id']);

        // Check if the record exists
        if (!$record) {
            return response()->json(['message' => 'Subject Record not found'], 404);
        }

        // Update the status of the SubjectRecord
        $record->status = $validated['status'];
        $record->save();

        // Return success response with the updated record
        return response()->json(['message' => 'Subject Record updated successfully', 'record' => $record]);
    }
}
