<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Get all employees.
     */
    public function index()
    {
        $employees = Employee::all(); // Fetch 10 employees per page

        return response()->json([
            'success' => true,
            'data' => $employees
        ], 200);
    }
}
