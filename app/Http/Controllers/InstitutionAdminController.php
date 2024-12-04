<?php

namespace App\Http\Controllers;

use App\Models\Institution;
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
    public function index(Request $request)
    {
        $query = InstitutionAdmin::with(['user', 'institution']);

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhereHas('institution', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan status institusi
        if ($request->has('status') && $request->status != '') {
            $query->whereHas('institution', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $userInstitutions = $query->get();

        return response()->json($userInstitutions);
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
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'user.username' => 'required|string|unique:users,username',
            'user.password' => 'required|string|min:8',
            'user.email' => 'required|email|unique:users,email',
            'institution_id' => 'required|exists:institutions,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create a new user
        $user = User::create([
            'username' => $request->input('user.username'),
            'password' => bcrypt($request->input('user.password')),
            'email' => $request->input('user.email'),
        ]);

        // Create the InstitutionAdmin linked to the new user
        $institutionAdmin = InstitutionAdmin::create([
            'user_id' => $user->id,
            'institution_id' => $request->institution_id,
            'name' => $request->name,
            'title' => $request->title,
        ]);

        return response()->json($institutionAdmin->load(['user', 'institution']), 201);
    }

    /**
     * Display the specified Institution admin.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $institutionAdmin = InstitutionAdmin::with(['user', 'institution'])
            ->where('id', $id)
            // ->where('is_deleted', false)
            ->first();

        if (!$institutionAdmin) {
            return response()->json(['error' => 'Institution Admin not found'], 404);
        }

        return response()->json($institutionAdmin);
    }

    /**
     * Update the specified Institution admin in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Find the institution admin by ID
        $institutionAdmin = InstitutionAdmin::find($id);

        if (!$institutionAdmin || $institutionAdmin->is_deleted) {
            return response()->json(['error' => 'Institution Admin not found'], 404);
        }

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'institution_id' => 'required|exists:institutions,id',
            'user.username' => 'required|string|max:255',
            'user.email' => 'required|email|max:255|unique:users,email,' . $institutionAdmin->user->id,
        ]);

        // Update InstitutionAdmin fields
        $institutionAdmin->update([
            'name' => $validated['name'],
            'title' => $validated['title'],
            'institution_id' => $validated['institution_id']
        ]);

        // Update User fields
        $institutionAdmin->user->update([
            'username' => $validated['user']['username'],
            'email' => $validated['user']['email'],
        ]);

        // Return the updated institution admin with its related data (user and institution)
        return response()->json($institutionAdmin->load(['user', 'institution']));
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

    public function disable($id){
        $institutionAdmin = InstitutionAdmin::find($id);
        if(!empty($institutionAdmin)){
            $institutionAdmin->user->is_deleted = 1;
            $institutionAdmin->user->save();
            return response()->json([
                'message' => $institutionAdmin->user->username . ' disabled successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Institution Admin not found'
            ], 404);
        }
    }
}
