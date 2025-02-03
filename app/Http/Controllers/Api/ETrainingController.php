<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ETraining;
use App\Models\User;

class ETrainingController extends Controller
{
    public function index()
    {
        return response()->json(ETraining::all(), 200);
    }

    public function getByUserId($userId)
    {
        $user = User::with('eTrainings')->find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user->eTrainings, 200);
    }
}
