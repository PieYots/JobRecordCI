<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ETraining;
use Illuminate\Http\JsonResponse;

class ETrainingController extends Controller
{
    public function index()
    {
        return ETraining::all();
    }
}
