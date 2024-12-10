<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
class StudentController extends Controller
{
    public function index(Request $request)
    {
        // $students = Student::all();
        // return response()->json($students);
        $search = $request->input('search');
        $institutionId = $request->input('institution_id');

        // Fetch students with optional filtering
        $students = Student::with(['institution' => function ($query) {
            $query->select('id', 'name', 'status', 'educational_level');  // Limit the fields from the Institution model
        }])
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->when($institutionId, function ($query) use ($institutionId) {
                return $query->where('institution_id', $institutionId);
            })
            ->orderBy('created_at', 'desc') // Sort by latest data
            ->get();

        return response()->json($students);
    }

    public function store(Request $request)
    {
        //     \Log::info($request->all()); // Log incoming data
        // return response()->json(['data' => $request->all()]);
        $validatedData = $request->validate([
            'student_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:15',
            'year' => 'required|integer',
            'major' => 'required|string|max:255',
            'gender' => 'required|string|in:Male,Female',
            'institution_id' => 'required|exists:institutions,id',
        ]);

        // Save the student
        $student = Student::create([
            'student_id' => $validatedData['student_id'],
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt('password'),
            'phone' => $validatedData['phone'],
            'year' => $validatedData['year'],
            'major' => $validatedData['major'],
            'gender' => $validatedData['gender'],
            'institution_id' => $validatedData['institution_id'],
        ]);

        return response()->json([
            'message' => 'Student added successfully!',
            'student' => $student,
        ], 201);
    }


    public function show($id)
    {
        $student = Student::with(['institution' => function ($query) {
            $query->select('id', 'name', 'status', 'educational_level'); // Limit the fields from the Institution model
        }])->find($id);

        if ($student) {
            return response()->json($student);
        } else {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }
    }


    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if (!empty($student)) {
            $student->name = $request->name;
            $student->institution_id = $request->institution_id;
            $student->save();
            return response()->json([
                'message' => 'Student updated successfully',
                'student' => $student
            ], 200);
        } else {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        $student = Student::find($id);
        if (!empty($student)) {
            $student->delete();
            return response()->json([
                'message' => 'Student deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }
    }

    public function login(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Find the student by email
        $student = Student::where('email', $validatedData['email'])->first();

        // Check if the student exists and the password matches
        if ($student && Hash::check($validatedData['password'], $student->password)) {
            // Authentication successful, return student data
            return response()->json([
                'message' => 'Login successful!',
                'student' => $student,
            ], Response::HTTP_OK);
        } else {
            // Authentication failed
            return response()->json([
                'message' => 'Invalid email or password',
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function getStudentsByInstitution(Request $request, $institutionId)
    {
        // Start the query to fetch students by institution
        $query = Student::where('institution_id', $institutionId)
            ->with('institution'); // Eager load the institution relationship

        // Apply filters for major and year if present in the request
        if ($request->has('major')) {
            $query->where('major', $request->input('major'));
        }

        if ($request->has('year')) {
            $query->where('year', $request->input('year'));
        }

        // Execute the query
        $students = $query->get();

        // Check if students are found
        if ($students->isEmpty()) {
            return response()->json(['error' => 'No students found for the given institution'], 404);
        }

        return response()->json($students);
    }
}
