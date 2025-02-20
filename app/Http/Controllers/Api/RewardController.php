<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RewardController extends Controller
{
    // Get all rewards
    public function index()
    {
        return response()->json(Reward::all(), 200);
    }

    // Get reward by ID
    public function show($id)
    {
        $reward = Reward::find($id);
        if (!$reward) {
            return response()->json(['message' => 'Reward not found'], 404);
        }
        return response()->json($reward, 200);
    }

    // Edit reward
    public function update(Request $request)
    {
        // Validate input, including the ID from the request body
        $validatedData = $request->validate([
            'id' => 'required|exists:rewards,id',
            'reward_name' => 'nullable|string|max:255',
            'reward_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', // 2MB max
            'reward_point' => 'nullable|integer|min:0',
            'reward_left' => 'nullable|integer|min:0',
        ]);

        // Find the reward
        $reward = Reward::find($validatedData['id']);
        if (!$reward) {
            return response()->json(['message' => 'Reward not found'], 404);
        }

        // Handle image upload
        if ($request->hasFile('reward_image')) {
            // Delete old image if it exists
            if ($reward->reward_image && Storage::disk('public')->exists($reward->reward_image)) {
                Storage::disk('public')->delete($reward->reward_image);
            }

            // Store new image
            $imagePath = $request->file('reward_image')->store('reward_images', 'public');
            $validatedData['reward_image'] = $imagePath;
        }

        // Update reward
        $reward->update($validatedData);

        return response()->json([
            'message' => 'Reward updated successfully',
            'data' => $reward,
        ], 200);
    }



    // Redeem reward
    public function redeem(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'reward_id' => 'required|exists:rewards,id',
        ]);

        $employee = Employee::find($request->employee_id);
        $reward = Reward::find($request->reward_id);

        if ($reward->reward_left <= 0) {
            return response()->json(['message' => 'Reward out of stock'], 400);
        }

        if ($employee->score < $reward->reward_point) {
            return response()->json(['message' => 'Not enough points'], 400);
        }

        // Deduct points and decrease reward stock
        $employee->score -= $reward->reward_point;
        $employee->save();

        $reward->reward_left -= 1;
        $reward->save();

        return response()->json(['message' => 'Reward redeemed successfully'], 200);
    }
}
