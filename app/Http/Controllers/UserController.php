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
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        // Check the password using the appropriate method
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email or password',
            ], 401);
        }

        // Generate a token after successful login
        $token = $user->createToken('authToken')->plainTextToken;

        // Successful login
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'token' => $token
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

    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // bcrypt() for hashing
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ]);
    }
}
