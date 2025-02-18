<?php



namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function index()
    {
        return User::all(); // Fetch all users
    }

    public function changeRole(Request $request)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id'
        ]);

        // Find the user
        $user = User::findOrFail($request->user_id);

        // Update the role
        $user->role_id = $request->role_id;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User role updated successfully',
            'data' => $user
        ], 200);
    }
}
