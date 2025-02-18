<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ScoreHelper;

class ScoreCriteriaController extends Controller
{
    /**
     * Update an employee's score via API.
     */
    public function updateScore(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'score_criteria_id' => 'required|exists:score_criteria,id'
        ]);

        // Call the helper function
        $response = ScoreHelper::fillEmployeeByCriteria($validated['employee_id'], $validated['score_criteria_id']);

        return response()->json($response, $response['success'] ? 200 : 500);
    }
}
