<?php

namespace App\Helpers;

use App\Models\Employee;
use App\Models\ScoreCriteria;
use App\Models\CompetitiveRecord;
use Illuminate\Support\Facades\Log;

class ScoreHelper
{
    public static function fillEmployeeByCriteria($employeeId, $scoreCriteriaId)
    {
        try {
            $scoreCriteria = ScoreCriteria::findOrFail($scoreCriteriaId);
            $employee = Employee::findOrFail($employeeId);

            $employee->score += $scoreCriteria->score;
            $employee->save();

            return [
                'success' => true,
                'message' => "Employee score updated successfully using ScoreCriteria ID: $scoreCriteriaId",
                'data' => $employee
            ];
        } catch (\Exception $e) {
            Log::error('Error updating employee score: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to update employee score',
                'error' => $e->getMessage()
            ];
        }
    }

    public static function addEmployeeScore($employeeId, $point)
    {
        try {
            $employee = Employee::findOrFail($employeeId);
            $employee->score += $point;
            $employee->save();

            return [
                'success' => true,
                'message' => "Employee score increased by $point for Employee ID: $employeeId",
                'data' => $employee
            ];
        } catch (\Exception $e) {
            Log::error('Error updating employee score: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to update employee score',
                'error' => $e->getMessage()
            ];
        }
    }

    public static function addCompetitiveScore($competitiveId, $point)
    {
        try {
            $competitive = CompetitiveRecord::findOrFail($competitiveId);
            $competitive->score += $point;
            $competitive->save();

            return [
                'success' => true,
                'message' => "Competitive score increased by $point for Competitive ID: $competitiveId",
                'data' => $competitive
            ];
        } catch (\Exception $e) {
            Log::error('Error updating competitive score: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to update competitive score',
                'error' => $e->getMessage()
            ];
        }
    }
}
