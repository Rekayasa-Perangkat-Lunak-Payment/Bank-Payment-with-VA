<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\VirtualAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the transactions.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Transaction::with([
            'virtual_account.invoice.student',
            'virtual_account.invoice.paymentPeriod.institution',
            'virtual_account.invoice.invoiceItems',
        ]);

        // Filter based on search term
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('virtual_account.invoice.student', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Filter based on institution id
        if ($request->has('institution_id') && $request->institution_id != '') {
            $query->whereHas('virtual_account.invoice.paymentPeriod.institution', function ($q) use ($request) {
                $q->where('id', $request->institution_id);
            });
        }

        $transactions = $query->paginate(10); // Paginate results

        return response()->json($transactions);
    }

    /**
     * Store a newly created transaction in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'virtual_account_number' => 'required|string',
            'transaction_date' => 'required|date|date_format:Y-m-d',
            'total' => 'required|numeric|min:0',
        ]);
        
        // Custom validation for transaction_date to be today's date
        if ($validator->passes()) {
            $transactionDate = $request->input('transaction_date');
            $today = now()->format('Y-m-d'); // Get today's date in Y-m-d format
        
            if ($transactionDate !== $today) {
                return response()->json([
                    'errors' => [
                        'transaction_date' => ['The transaction date must be today.'],
                        'date' => now()->format('Y-m-d'),
                    ],
                ], 422);
            }
        }

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'date' => now()->format('Y-m-d'),
            ], 422);
        }

        // Find the Virtual Account by virtual_account_number
        $virtualAccount = VirtualAccount::where('virtual_account_number', $request->virtual_account_number)->first();

        if (!$virtualAccount || !$virtualAccount->is_active) {
            return response()->json(['message' => 'Virtual Account not found or is inactive'], 404);
        }

        // Check if the Virtual Account has expired
        if (now()->greaterThan($virtualAccount->expired_at)) {
            return response()->json(['message' => 'Virtual Account is expired'], 400);
        }

        // Check if the total amount matches the Virtual Account's total_amount
        if ((float)$request->total !== (float)$virtualAccount->total_amount) {
            return response()->json(['message' => 'Invalid transaction amount'], 400);
        }

        // Create the transaction
        $transaction = Transaction::create([
            'virtual_account_id' => $virtualAccount->id,
            'transaction_date' => $request->transaction_date,
            'total' => $request->total,
        ]);

        // Mark the Virtual Account as inactive
        $virtualAccount->update(['is_active' => 0]);

        return response()->json($transaction, 201);
    }

    /**
     * Display the specified transaction.
     *
     * @param int $id
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
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'virtual_account_id' => 'sometimes|exists:virtual_accounts,id',
            'transaction_date' => 'sometimes|date',
            'total' => 'sometimes|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], Response::HTTP_NOT_FOUND);
        }

        // Update transaction fields
        $transaction->update($request->all());

        return response()->json($transaction, Response::HTTP_OK);
    }

    /**
     * Remove the specified transaction from storage.
     *
     * @param int $id
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

    /**
     * Get transactions by institution ID.
     *
     * @param int $institutionId
     * @return \Illuminate\Http\Response
     */
    public function getTransactionsByInstitutionId($institutionId)
    {
        $transactions = Transaction::with([
            'virtual_account.invoice.student',
            'virtual_account.invoice.paymentPeriod.institution',
            'virtual_account.invoice.invoiceItems',
        ])
            ->whereHas('virtual_account.invoice.paymentPeriod.institution', function ($query) use ($institutionId) {
                $query->where('id', $institutionId);
            })
            ->paginate(10); // Paginate results

        return response()->json($transactions);
    }

    /**
     * Get transactions by institution ID and payment period ID.
     *
     * @param int $institutionId
     * @param int $paymentPeriodId
     * @return \Illuminate\Http\Response
     */
    public function getTransactionsByInstitutionIdAndPaymentPeriodId($institutionId, $paymentPeriodId)
    {
        $transactions = Transaction::with([
            'virtual_account.invoice.student',
            'virtual_account.invoice.paymentPeriod.institution',
            'virtual_account.invoice.invoiceItems',
        ])
            ->whereHas('virtual_account.invoice.paymentPeriod.institution', function ($query) use ($institutionId) {
                $query->where('id', $institutionId);
            })
            ->whereHas('virtual_account.invoice.paymentPeriod', function ($query) use ($paymentPeriodId) {
                $query->where('id', $paymentPeriodId);
            })
            ->paginate(10); // Paginate results

        return response()->json($transactions);
    }
}
