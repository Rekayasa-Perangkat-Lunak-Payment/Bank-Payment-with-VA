<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\BankAdmin;
class BankAdminController extends Controller
{
    /**
     * Display a listing of the Bank admins.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bankAdmins = BankAdmin::where('is_deleted', false)->get();
        return response()->json($bankAdmins);
    }

    /**
     * Store a newly created bank admin in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:bank_admins,username',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $bankAdmin = BankAdmin::create($request->only(['username', 'password']));
        return response()->json($bankAdmin, 201);
    }

    /**
     * Display the specified Bank admin.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bankAdmin = BankAdmin::find($id);

        if (!$bankAdmin || $bankAdmin->is_deleted) {
            return response()->json(['error' => 'Bank Admin not found'], 404);
        }

        return response()->json($bankAdmin);
    }

    /**
     * Update the specified Bank admin in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bankAdmin = BankAdmin::find($id);

        if (!$bankAdmin || $bankAdmin->is_deleted) {
            return response()->json(['error' => 'Bank Admin not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'username' => 'sometimes|string|unique:bank_admins,username,' . $id,
            'password' => 'sometimes|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->has('username')) {
            $bankAdmin->username = $request->username;
        }
        if ($request->has('password')) {
            $bankAdmin->password = $request->password; // Will trigger setPasswordAttribute to hash
        }
        $bankAdmin->save();

        return response()->json($bankAdmin);
    }

    /**
     * Soft delete the specified Bank admin.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bankAdmin = BankAdmin::find($id);

        if (!$bankAdmin || $bankAdmin->is_deleted) {
            return response()->json(['error' => 'Bank Admin not found'], 404);
        }

        $bankAdmin->is_deleted = true;
        $bankAdmin->save();

        return response()->json(['message' => 'Bank Admin deleted successfully']);
    }
}
