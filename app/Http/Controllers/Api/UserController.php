<?php



namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function index()
    {
        return User::all(); // Fetch all users
    }
}
