<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SupportStrategy;
use Illuminate\Http\Request;

class SupportStrategyController extends Controller
{
    public function index()
    {
        return SupportStrategy::all();
    }
}
