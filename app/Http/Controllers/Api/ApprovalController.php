<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ScoreHelper;
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
        $record = StpmRecord::with('employees')->findOrFail($validated['id']);
        $record->update(['status' => $validated['status']]);

        // If status is 'pass', update employee scoring flag
        if ($validated['status'] === 'pass') {
            foreach ($record->employees as $employee) {
                // Ensure the pivot data is loaded for each employee
                if ($employee->pivot) {

                    // Get the last two approved records for the same job_id
                    $lastTwoApprovedRecords = $this->getLastTwoApprovedRecordsForEmployeeAndJob($employee->id, $record->job_id);

                    // Determine if scoring should be applied
                    $isScoring = $this->shouldApplyScoring($lastTwoApprovedRecords, $employee->id);

                    // Update the pivot table with the scoring flag
                    foreach ($lastTwoApprovedRecords as $approvedRecord) {
                        // Check if this record relates to the current employee
                        $employeePivot = $approvedRecord->employees->where('id', $employee->id)->first();

                        // If we found the matching pivot, update it
                        if ($employeePivot) {
                            $approvedRecord->employees()->updateExistingPivot($employee->id, [
                                'is_scoring' => $isScoring,
                            ]);
                        }
                    }

                    if ($isScoring) {
                        // Determine criteria based on OJT and E-Training
                        $scoreCriteria = $this->determineCriteria($lastTwoApprovedRecords, $employee->id);

                        // Update employee score
                        ScoreHelper::fillEmployeeByCriteria($employee->id, $scoreCriteria);
                    }
                } else {
                    // Handle the case where there's no pivot data for the employee
                    continue; // Skip employees with no pivot data
                }
            }
        }

        // Return only the record data without the message and record keys
        return response()->json($record);
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

    public function getLastTwoApprovedRecordsForEmployeeAndJob($employeeId, $jobId)
    {
        return StpmRecord::whereHas('employees', function ($query) use ($employeeId) {
            $query->where('employee_id', $employeeId)
                ->where('stpm_employee_records.is_scoring', false); // Ensure we only get unscored records
        })
            ->where('job_id', $jobId)
            ->where('status', 'pass')  // Ensure only approved records are considered
            ->latest()  // Sort by latest first
            ->take(2)
            ->get();
    }



    private function shouldApplyScoring($lastTwoApprovedRecords, $employeeId)
    {
        // Ensure there are exactly two approved records
        if ($lastTwoApprovedRecords->count() < 2) {
            return false; // Scoring doesn't apply if there are not two records
        }

        // Flags to track if both OJT and E-Training are present for the given employee
        $hasOjt = false;
        $hasEtraining = false;

        foreach ($lastTwoApprovedRecords as $record) {
            // Loop through the employees of each record and check for the specific employee
            foreach ($record->employees as $employee) {
                if ($employee->id == $employeeId && $employee->pivot) {
                    // Check for OJT and E-Training records for the specific employee
                    if ($employee->pivot->ojt_record_id !== null) {
                        $hasOjt = true;
                    }
                    if ($employee->pivot->e_training_id !== null) {
                        $hasEtraining = true;
                    }
                }
            }
        }

        // Determine if scoring applies based on the presence of OJT and E-Training for the specific employee
        if ($hasOjt && $hasEtraining) {
            return true; // Both OJT and E-Training found, scoring applies
        } elseif ($hasOjt || $hasEtraining) {
            return true; // Only one of OJT or E-Training found, scoring applies
        }

        return false; // Neither OJT nor E-Training found, scoring does not apply
    }


    private function determineCriteria($lastTwoApprovedRecords, $employeeId)
    {
        // Flags to track presence of OJT and E-Training
        $ojtPresent = false;
        $etrainingPresent = false;

        // Check if records are not empty and valid
        if ($lastTwoApprovedRecords->isEmpty()) {
            return 3;  // No records, default to criteria 3 (neither OJT nor E-Training)
        }

        foreach ($lastTwoApprovedRecords as $record) {
            // Loop through the employees of each record and check for the specific employee
            foreach ($record->employees as $employee) {
                if ($employee->id == $employeeId && $employee->pivot) {
                    // Check for OJT and E-Training records for the specific employee
                    if ($employee->pivot->ojt_record_id !== null) {
                        $ojtPresent = true;
                    }
                    if ($employee->pivot->e_training_id !== null) {
                        $etrainingPresent = true;
                    }
                }
            }
        }

        // Determine the criteria ID based on the flags
        if ($ojtPresent && $etrainingPresent) {
            // Case 1: Both OJT and E-Training are present
            return 1;
        } elseif ($ojtPresent || $etrainingPresent) {
            // Case 2: Only one (either OJT or E-Training) is present
            return 2;
        } else {
            // Case 3: Neither OJT nor E-Training are present
            return 3;
        }
    }
}
