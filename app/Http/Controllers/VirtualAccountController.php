<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VirtualAccount;
use App\Models\Transaction;
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
        $invoices = VirtualAccount::with([
            'invoice' => function ($query) {
                $query->select('id', 'student_id', 'payment_period_id', 'total_amount');
            },
            'invoice.student' => function ($query) {
                $query->select('id', 'student_id', 'name');
            },
            'invoice.paymentPeriod' => function ($query) {
                $query->select('id', 'month', 'year', 'semester');
            },
            'invoice.invoiceItems.itemType' => function ($query) {
                $query->select('id', 'name', 'description');
            }
        ])->get()->map(function ($virtualAccount) {
            // Check if the virtual account has a corresponding transaction
            $isPaid = Transaction::where('virtual_account_id', $virtualAccount->id)->exists();

            // Determine status
            $status = 'Unpaid';
            if ($isPaid) {
                $status = 'Paid';
            } elseif ($virtualAccount->is_expired) {
                $status = 'Expired';
            }

            // Append status to the virtual account data
            $virtualAccount->status = $status;

            return $virtualAccount;
        });

        return response()->json($invoices);
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
        // Fetch the virtual account and its related data
        $virtualAccount = VirtualAccount::with([
            'invoice' => function ($query) {
                $query->select('id', 'student_id', 'payment_period_id', 'total_amount');
            },
            'invoice.student' => function ($query) {
                $query->select('id', 'name');
            },
            'invoice.paymentPeriod' => function ($query) {
                $query->select('id', 'month', 'year', 'semester');
            },
            'invoice.invoiceItems.itemType' => function ($query) {
                $query->select('id', 'name', 'description');
            }
        ])->find($id);

        // Check if the virtual account exists
        if (!$virtualAccount) {
            return response()->json(['message' => 'Virtual Account not found'], 404);
        }

        // Check if the virtual account has a corresponding transaction
        $isPaid = Transaction::where('virtual_account_id', $virtualAccount->id)->exists();

        // Determine status
        $status = 'Unpaid';
        if ($isPaid) {
            $status = 'Paid';
        } elseif ($virtualAccount->is_expired) {
            $status = 'Expired';
        }

        // Append status to the virtual account data
        $virtualAccount->status = $status;

        return response()->json($virtualAccount);
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
