<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\ETraining;
use App\Models\User;

class ETrainingController extends Controller
{
    public function index()
    {
        return response()->json(ETraining::all(), 200);
    }

    public function getByEmployeeId($employeeId)
    {
        $employee = Employee::with('eTrainings')->find($employeeId);

        if (!$employee) {
            return response()->json(['message' => 'E-Training not found'], 404);
        }

        return response()->json($employee->eTrainings, 200);
    }
}
