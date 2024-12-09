<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Symfony\Component\HttpFoundation\Response;
use App\Models\VirtualAccount;

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions.
     *
     * @return \Illuminate\Http\Response
     */
        /**
     * Display a listing of transactions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::with([
            'virtual_account.invoice.student',
            'virtual_account.invoice.paymentPeriod.institution',
            'virtual_account.invoice.invoiceItems',
        ])
            ->get()
            ->map(function ($transaction) {
                // Append status to the virtual account
                if ($transaction->virtual_account) {
                    $transaction->virtual_account->status = $this->determineVirtualAccountStatus($transaction->virtual_account);
                }
                return $transaction;
            });

        return response()->json($transactions);
    }

    /**
     * Reusable method to determine the status of a virtual account.
     *
     * @param \App\Models\VirtualAccount $virtualAccount
     * @return string
     */
    protected function determineVirtualAccountStatus($virtualAccount)
    {
        $isPaid = Transaction::where('virtual_account_id', $virtualAccount->id)->exists();
        $isExpired = now()->greaterThan($virtualAccount->expired_at);

        if ($isPaid) {
            return 'Paid';
        }

        if ($isExpired) {
            return 'Expired';
        }

        return 'Unpaid';
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
            'virtual_account_number' => 'required|string',
            'transaction_date' => 'required|date|before_or_equal:today',
            'total' => 'required|numeric|min:0',
        ]);

        // Find the Virtual Account by virtual_account_number
        $virtualAccount = VirtualAccount::where('virtual_account_number', $request->virtual_account_number)->first();

        if (!$virtualAccount || !$virtualAccount->is_active) {
            return response()->json(['message' => 'Virtual Account not found or is inactive'], Response::HTTP_NOT_FOUND);
        }

        if (now()->greaterThan($virtualAccount->expired_at)) {
            return response()->json(['message' => 'Virtual Account is expired'], Response::HTTP_BAD_REQUEST);
        }

        // Check if the total amount matches the Virtual Account's total_amount
        if ((float)$request->total !== (float)$virtualAccount->total_amount) {
            return response()->json(['message' => 'Invalid transaction amount'], Response::HTTP_BAD_REQUEST);
        }

        // Create the transaction
        $transaction = \App\Models\Transaction::create([
            'virtual_account_id' => $virtualAccount->id,
            'transaction_date' => $request->transaction_date,
            'total' => $request->total,
        ]);

        // Mark the Virtual Account as inactive
        $virtualAccount->update(['is_active' => 0]);

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
