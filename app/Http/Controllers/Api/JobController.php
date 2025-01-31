<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\JsonResponse;

class JobController extends Controller
{
    public function index()
    {
        return Job::all();
    }
}
