<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution;

class InstitutionController extends Controller
{
    public function index()
    {
        $institutions = Institution::withCount(['admins', 'students'])->get();
        return response()->json($institutions);
    }

    public function store(Request $request)
    {
        // dd($request->all()); 
        $validated = $request->validate([
            'npsn' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'educational_level' => 'required|string|max:50',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:institutions,email',
            'account_number' => 'nullable|string|max:50',
        ]);

        // Insert only the fields defined in the $fillable array
        $institute = Institution::create($validated);

        // Return a response
        return response()->json([
            'message' => 'Institute created successfully',
            'data' => $institute,
        ], 201);
    }

    public function show($id)
    {
        $institution = Institution::withCount(['admins', 'students'])->find($id);
        if (!empty($institution)) {
            return response()->json($institution);
        } else {
            return response()->json([
                'message' => 'Institution not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        // Find the institution by ID
        $institution = Institution::findOrFail($id);

        // Validate incoming data (all fields)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'educational_level' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'account_number' => 'nullable|string|max:20',
            'balance' => 'required|numeric',
        ]);

        // If validation fails, Laravel will automatically return a 422 response with the errors.
        // You can handle that with a try-catch block or simply rely on Laravel's automatic behavior.

        try {
            // Update the institution with the validated data
            $institution->update($validatedData);

            // Return the updated institution as a JSON response
            return response()->json($institution, 200);
        } catch (\Exception $e) {
            // If any error occurs during update, return a 500 error
            return response()->json(['error' => 'Failed to update institution', 'message' => $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        $institution = Institution::find($id);
        if (!empty($institution)) {
            $institution->delete();
            return response()->json([
                'message' => 'Institution deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Institution not found'
            ], 404);
        }
    }
}
