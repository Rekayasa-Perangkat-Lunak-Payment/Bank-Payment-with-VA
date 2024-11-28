<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::all();
        return response()->json($transactions, Response::HTTP_OK);
    }

    /**
     * Store a newly created transaction in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'virtual_account_id' => 'required|exists:virtual_accounts,id',
            'transaction_date' => 'required|date',
            'total' => 'required|numeric|min:0',
        ]);

        $transaction = Transaction::create($request->all());

        return response()->json($transaction, Response::HTTP_CREATED);
    }

    /**
     * Display the specified transaction.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($transaction, Response::HTTP_OK);
    }

    /**
     * Update the specified transaction in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'virtual_account_id' => 'sometimes|exists:virtual_accounts,id',
            'transaction_date' => 'sometimes|date',
            'total' => 'sometimes|numeric|min:0',
        ]);

        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], Response::HTTP_NOT_FOUND);
        }

        $transaction->update($request->all());

        return response()->json($transaction, Response::HTTP_OK);
    }

    /**
     * Remove the specified transaction from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], Response::HTTP_NOT_FOUND);
        }

        $transaction->delete();

        return response()->json(['message' => 'Transaction deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
