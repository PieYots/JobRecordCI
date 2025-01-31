<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use Illuminate\Http\JsonResponse;

class MachineController extends Controller
{
    public function index()
    {
        return Machine::all();
    }
}
