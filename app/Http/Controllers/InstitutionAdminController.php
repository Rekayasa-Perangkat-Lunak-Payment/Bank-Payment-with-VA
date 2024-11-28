<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InstitutionAdmin;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class InstitutionAdminController extends Controller
{
    /**
     * Display a listing of the Institution admins.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institutionAdmins = InstitutionAdmin::where('is_deleted', false)->get();
        return response()->json($institutionAdmins);
    }

    /**
     * Store a newly created Institution admin in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:institution_admins,username',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $institutionAdmin = InstitutionAdmin::create($request->only(['username', 'password']));
        return response()->json($institutionAdmin, 201);
    }

    /**
     * Display the specified Institution admin.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $institutionAdmin = InstitutionAdmin::find($id);

        if (!$institutionAdmin || $institutionAdmin->is_deleted) {
            return response()->json(['error' => 'Institution Admin not found'], 404);
        }

        return response()->json($institutionAdmin);
    }

    /**
     * Update the specified institution admin in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $institutionAdmin = InstitutionAdmin::find($id);

        if (!$institutionAdmin || $institutionAdmin->is_deleted) {
            return response()->json(['error' => 'Institution Admin not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'username' => 'sometimes|string|unique:Institution_admins,username,' . $id,
            'password' => 'sometimes|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->has('username')) {
            $institutionAdmin->username = $request->username;
        }
        if ($request->has('password')) {
            $institutionAdmin->password = $request->password; // Will trigger setPasswordAttribute to hash
        }
        $institutionAdmin->save();

        return response()->json($institutionAdmin);
    }

    /**
     * Soft delete the specified institution admin.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $institutionAdmin = InstitutionAdmin::find($id);

        if (!$institutionAdmin || $institutionAdmin->is_deleted) {
            return response()->json(['error' => 'Institution Admin not found'], 404);
        }

        $institutionAdmin->is_deleted = true;
        $institutionAdmin->save();

        return response()->json(['message' => 'Institution Admin deleted successfully']);
    }
}
