<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VirtualAccount;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
class VirtualAccountController extends Controller
{
    /**
     * Display a listing of virtual accounts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $virtualAccounts = VirtualAccount::all();
        return response()->json($virtualAccounts, Response::HTTP_OK);
    }

    /**
     * Store a newly created virtual account in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'school_id' => 'required',
            'NIM' => 'required',
            'expired_at' => 'required|date',
            'nominal' => 'required|numeric|min:0',
        ]);

        // Generate the virtual account number based on NIM, School ID, and timestamp
        $timestamp = Carbon::now()->format('YmdHis');
        $virtualAccountNumber = $request->NIM . $request->school_id . $timestamp;

        $virtualAccount = VirtualAccount::create([
            'student_id' => $request->student_id,
            'virtual_account_number' => $virtualAccountNumber,
            'expired_at' => $request->expired_at,
            'is_active' => $request->is_active ?? true,
            'nominal' => $request->nominal,
        ]);

        return response()->json($virtualAccount, Response::HTTP_CREATED);
    }

    /**
     * Display the specified virtual account.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $virtualAccount = VirtualAccount::find($id);

        if (!$virtualAccount) {
            return response()->json(['message' => 'Virtual Account not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($virtualAccount, Response::HTTP_OK);
    }

    /**
     * Update the specified virtual account in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'expired_at' => 'sometimes|date',
            'is_active' => 'sometimes|boolean',
            'nominal' => 'sometimes|numeric|min:0',
        ]);

        $virtualAccount = VirtualAccount::find($id);

        if (!$virtualAccount) {
            return response()->json(['message' => 'Virtual Account not found'], Response::HTTP_NOT_FOUND);
        }

        $virtualAccount->update($request->all());

        return response()->json($virtualAccount, Response::HTTP_OK);
    }

    /**
     * Remove the specified virtual account from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $virtualAccount = VirtualAccount::find($id);

        if (!$virtualAccount) {
            return response()->json(['message' => 'Virtual Account not found'], Response::HTTP_NOT_FOUND);
        }

        $virtualAccount->delete();

        return response()->json(['message' => 'Virtual Account deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
