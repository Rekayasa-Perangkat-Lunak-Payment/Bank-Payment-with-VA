<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VirtualAccount;
use App\Models\Transaction;
use App\Models\PaymentPeriod;
use App\Models\Student;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

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

    public function getVirtualAccountsByPaymentPeriod($id)
    {
        // Fetch virtual accounts related to the given payment period
        $virtualAccounts = VirtualAccount::whereHas('invoice', function ($query) use ($id) {
            $query->where('payment_period_id', $id);
        })
            ->with('invoice.student.institution') // Load related student via invoice
            ->get();

        return response()->json($virtualAccounts);
    }

    public function storeBulkVirtualAccounts(Request $request)
    {
        // Validate the request
        $request->validate([
            'payment_period_id' => 'required|exists:payment_periods,id',
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
        ]);

        $paymentPeriodId = $request->input('payment_period_id');
        $students = $request->input('students');

        // Start a transaction to ensure all inserts succeed or fail together
        DB::beginTransaction();

        try {
            foreach ($students as $studentId) {
                VirtualAccount::create([
                    'student_id' => $studentId,
                    'payment_period_id' => $paymentPeriodId,
                    'virtual_account_number' => $this->generateVirtualAccountNumber(),
                    'total_amount' => 0, // Set default or calculated amount
                    'is_active' => 1,
                    'expired_date' => now()->addMonths(1), // Example expiry logic
                ]);
            }

            // Commit the transaction if all inserts succeed
            DB::commit();

            return response()->json(['message' => 'Virtual accounts created successfully!'], 201);
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();

            // Log the error for debugging
            \Log::error('Error creating bulk virtual accounts: ' . $e->getMessage());

            return response()->json(['message' => 'Failed to create virtual accounts. Please try again.'], 500);
        }
    }


    // Helper function to generate unique virtual account numbers
    private function generateVirtualAccountNumber()
    {
        // Simple example of generating a random number, adjust as needed for your use case
        return 'VA' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
    }


    public function getStudentsByPaymentPeriod(Request $request, $paymentPeriodId)
    {
        $paymentPeriod = PaymentPeriod::with('institution')->findOrFail($paymentPeriodId);
        $institutionId = $paymentPeriod->institution_id;

        $query = Student::where('institution_id', $institutionId);

        if ($request->has('year')) {
            $query->where('year', $request->input('year'));
        }

        if ($request->has('major')) {
            $query->where('major', $request->input('major'));
        }

        return response()->json($query->get());
    }

    public function getAvailableFilterOptions($paymentPeriodId)
    {
        // Get the payment period and related institution
        $paymentPeriod = PaymentPeriod::with('institution')->findOrFail($paymentPeriodId);
        $institutionId = $paymentPeriod->institution_id;

        // Get unique years and majors for students in this institution
        $years = Student::where('institution_id', $institutionId)->pluck('year')->unique()->values();
        $majors = Student::where('institution_id', $institutionId)->pluck('major')->unique()->values();

        return response()->json([
            'years' => $years,
            'majors' => $majors,
        ]);
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
