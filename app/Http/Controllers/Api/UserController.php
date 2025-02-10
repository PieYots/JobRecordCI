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

    public function updateRole(Request $request)
    {
        // Validate request data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        // Find the user
        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'User not found'
            ], 404);
        }

        // Update role
        $user->role_id = $request->role_id;
        $user->save();

        // Return cleaned response
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'User role updated successfully',
            'data' => $user // Returns updated user directly
        ], 200);
    }
}
