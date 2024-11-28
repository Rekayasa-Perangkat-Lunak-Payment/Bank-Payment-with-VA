<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    public function store(Request $request){
        $student = new Student();
        $student->name = $request->name;
        $student->institution_id = $request->institution_id;
        $student->save();
        return response()->json([
            'message' => 'Student created successfully',
            'student' => $student
        ], 201);
    }

    public function getStudent($id){
        $student = Student::find($id);
        if(!empty($student)){
            return response()->json($student);
        }else{
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }
    }

    public function update(Request $request, $id){
        $student = Student::find($id);
        if(!empty($student)){
            $student->name = $request->name;
            $student->institution_id = $request->institution_id;
            $student->save();
            return response()->json([
                'message' => 'Student updated successfully',
                'student' => $student
            ], 200);
        }else{
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }
    }

    public function destroy($id){
        $student = Student::find($id);
        if(!empty($student)){
            $student->delete();
            return response()->json([
                'message' => 'Student deleted successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }
    }
}
