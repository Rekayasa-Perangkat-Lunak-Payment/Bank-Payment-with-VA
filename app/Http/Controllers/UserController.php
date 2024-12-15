<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        // Find the user by email
        $user = User::with('bankAdmin', 'institutionAdmin')->where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }
        // Check the password using Hash::check
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email or password',
                'data' => $user,
            ], 401);
        }

        $role = null;
        if ($user->bankAdmin) {
            $role = 'bank_admin';
        } elseif ($user->institutionAdmin) {
            $role = 'institution_admin';
        }

        // If no role is found, return an error
        if (!$role) {
            return response()->json([
                'status' => 'error',
                'message' => 'User does not have a valid role',
            ], 403);
        }

        // Generate a token after successful login
        $token = $user->createToken('authToken')->plainTextToken;

        // Successful login with role
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'token' => $token,
                'role' => $role,
                'user' => $user
            ]
        ]);
    }


    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        // Delete the user's current token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Get the authenticated user's profile.
     */
    public function profile(Request $request)
    {
        $user = $request->user()->load(['bankAdmin', 'institutionAdmin']);
        $role = $user->bankAdmin ? 'BankAdmin' : ($user->institutionAdmin ? 'InstitutionAdmin' : null);

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
                'role' => $role,
                'role_data' => $role ? $user->$role : null
            ]
        ]);
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $request->user()->id,
        ]);

        $user = $request->user();
        $user->update($request->only('name', 'email'));

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }
}
