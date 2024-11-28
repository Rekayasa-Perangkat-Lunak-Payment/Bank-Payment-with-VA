<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution;

class InstitutionController extends Controller
{
    public function index()
    {
        $institutions = Institution::all();
        return response()->json($institutions);
    }

    public function store(Request $request){
        $institution = new Institution();
        $institution->name = $request->name;
        $institution->institution_id = $request->institution_id;
        $institution->save();
        return response()->json([
            'message' => 'Institution created successfully',
            'institution' => $institution
        ], 201);
    }

    public function getInstitution($id){
        $institution = Institution::find($id);
        if(!empty($institution)){
            return response()->json($institution);
        }else{
            return response()->json([
                'message' => 'Institution not found'
            ], 404);
        }
    }

    public function update(Request $request, $id){
        $institution = Institution::find($id);
        if(!empty($institution)){
            $institution->name = $request->name;
            $institution->institution_id = $request->institution_id;
            $institution->save();
            return response()->json([
                'message' => 'Institution updated successfully',
                'institution' => $institution
            ], 200);
        }else{
            return response()->json([
                'message' => 'Institution not found'
            ], 404);
        }
    }

    public function destroy($id){
        $institution = Institution::find($id);
        if(!empty($institution)){
            $institution->delete();
            return response()->json([
                'message' => 'Institution deleted successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Institution not found'
            ], 404);
        }
    }
}
