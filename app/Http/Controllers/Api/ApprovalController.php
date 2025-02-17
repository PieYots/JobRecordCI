<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StpmRecord;
use App\Models\SubjectRecord;
use App\Models\OPL;
use App\Models\Improvement;
use App\Models\CompetitiveRecord;
use Illuminate\Http\JsonResponse;

class ApprovalController extends Controller
{
    /**
     * Approve or reject a StpmRecord.
     */
    public function approveStpmRecord(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'id' => 'required|integer|exists:stpm_records,id',
            'status' => 'required|in:waiting,pass,fail',
        ]);

        // Find and update record
        $record = StpmRecord::findOrFail($validated['id']);
        $record->update(['status' => $validated['status']]);

        return response()->json(['message' => 'Stpm Record updated successfully', 'record' => $record]);
    }

    /**
     * Approve or reject a SubjectRecord.
     */
    public function approveSubjectRecord(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'id' => 'required|integer|exists:subject_records,id',
            'status' => 'required|in:waiting,pass,fail',
        ]);

        // Find and update record
        $record = SubjectRecord::findOrFail($validated['id']);
        $record->update(['status' => $validated['status']]);

        return response()->json(['message' => 'Subject Record updated successfully', 'record' => $record]);
    }

    /**
     * Approve or reject an OPL record.
     */
    public function approveOpl(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'id' => 'required|integer|exists:opls,id',
            'status' => 'required|in:waiting,pass,fail',
        ]);

        // Find and update record
        $opl = OPL::findOrFail($validated['id']);
        $opl->update(['status' => $validated['status']]);

        return response()->json(['message' => 'OPL status updated successfully', 'data' => $opl], 200);
    }

    /**
     * Approve or reject an Improvement record (Change status)
     */
    public function approveImprovement(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:improvements,id',
            'status' => 'required|in:waiting,pass,fail',
        ]);

        $improvement = Improvement::findOrFail($request->id);
        $improvement->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Improvement status updated successfully',
            'data' => $improvement
        ], 200);
    }

    public function approveCompetitiveRecord(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|exists:competitive_records,id',
            'status' => 'required|in:waiting,pass,fail,ongoing,eliminated,qualify',
        ]);

        $record = CompetitiveRecord::findOrFail($request->id);
        $record->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Competitive Record status updated successfully',
            'data' => $record
        ], 200);
    }
}
