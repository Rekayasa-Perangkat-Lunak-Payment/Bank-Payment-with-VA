<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VirtualAccount;
use App\Models\Transaction;
use App\Models\PaymentPeriod;
use App\Models\Student;
use App\Models\Invoice;
use App\Models\InvoiceItem;
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

            // Determine if the virtual account is expired
            $isExpired = now()->greaterThan($virtualAccount->expired_at);

            // Determine status
            $status = 'Unpaid';
            if ($isPaid) {
                $status = 'Paid';
            } elseif ($isExpired) {
                $status = 'Expired';
            }

            // Append status to the virtual account data
            $virtualAccount->status = $status;

            return $virtualAccount;
        });

        return response()->json($invoices);
    }

    // Helper function to generate unique virtual account numbers
    public function generateVirtualAccountNumber(string $studentId, string $paymentPeriod)
    {
        // Get the current date in 'YYYYMMDD' format
        $date = now()->format('Ymd');

        // Combine the payment period, student ID, date, and a random 6-digit number
        return $paymentPeriod . $studentId . $date . str_pad(rand(100, 999), 4, '0', STR_PAD_LEFT);
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
            'invoice_id' => 'required|exists:invoices,id',
            'student_id' => 'required|exists:students,id',
            'institution_id' => 'required',
            'nim' => 'required',
            'expired_at' => 'required|date',
            'nominal' => 'required|numeric|min:0',
        ]);

        // Generate the virtual account number based on NIM, School ID, and timestamp
        $timestamp = Carbon::now()->format('YmdHis');
        $virtualAccountNumber = $this->generateVirtualAccountNumber($request->nim, $request->institution_id, $timestamp);

        $virtualAccount = VirtualAccount::create([
            'invoice_id' => $request->invoice_id,
            'virtual_account_number' => $virtualAccountNumber,
            'expired_at' => $request->expired_at,
            'is_active' => $request->is_active ?? true,
            'total_amount' => $request->nominal,
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

        // Determine statust
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

    public function getVirtualAccountsByPaymentPeriod(Request $request, $id)
    {
        // Fetch virtual accounts related to the given payment period
        $query = VirtualAccount::whereHas('invoice', function ($query) use ($id) {
            $query->where('payment_period_id', $id);
        })
            ->with([
                'invoice' => function ($query) {
                    $query->select('id', 'student_id', 'payment_period_id', 'total_amount');
                },
                'invoice.student' => function ($query) {
                    $query->select('id', 'name', 'institution_id');
                },
                'invoice.student.institution' => function ($query) {
                    $query->select('id', 'name');
                },
                'invoice.paymentPeriod' => function ($query) {
                    $query->select('id', 'month', 'year', 'semester');
                },
                'invoice.invoiceItems.itemType' => function ($query) {
                    $query->select('id', 'name', 'description');
                },
            ]);

        // Apply filters based on request parameters
        if ($request->has('name')) {
            $query->whereHas('invoice.student', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->has('virtual_account_number')) {
            $query->where('virtual_account_number', 'like', '%' . $request->virtual_account_number . '%');
        }

        $virtualAccounts = $query->get()->map(function ($virtualAccount) {
            // Check if the virtual account has a corresponding transaction
            $isPaid = Transaction::where('virtual_account_id', $virtualAccount->id)->exists();

            // Determine if the virtual account is expired
            $isExpired = now()->greaterThan($virtualAccount->expired_at);

            // Determine status
            $status = 'Unpaid';
            if ($isPaid) {
                $status = 'Paid';
            } elseif ($isExpired) {
                $status = 'Expired';
            }

            // Append status to the virtual account data
            $virtualAccount->status = $status;

            return $virtualAccount;
        });

        return response()->json($virtualAccounts);
    }

    public function storeBulkVirtualAccounts(Request $request)
    {
        $paymentPeriodId = $request->payment_period_id;
        $students = $request->students;
        $invoiceItems = $request->invoice_items; // Flat array of invoice items
        $creditCost = $request->credit_cost;
        $fixedCost = $request->fixed_cost;

        foreach ($students as $studentId) {
            $student = Student::findOrFail($studentId);

            // Create Invoice for the student
            $invoice = Invoice::create([
                'student_id' => $studentId,
                'payment_period_id' => $paymentPeriodId,
                'total_amount' => $fixedCost, // Initial total amount is fixed cost
            ]);

            // Add invoice items for the student
            $totalInvoiceAmount = $fixedCost; // Start with the fixed cost

            foreach ($invoiceItems as $item) {
                // Check if the item belongs to the current student
                if ($item['student_id'] == $studentId) {
                    $invoiceItem = InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'item_type_id' => $item['item_type_id'],
                        'description' => $item['description'],
                        'unit_price' => $item['amount'],
                        'quantity' => 1, // Default to 1 for simplicity
                        'price' => $item['amount'], // Total price is the amount for one item
                    ]);

                    // Add the item's amount to the total invoice amount
                    $totalInvoiceAmount += $item['amount'];
                }
            }

            // Update the total amount on the invoice
            $invoice->update(['total_amount' => $totalInvoiceAmount]);

            // Generate the virtual account number for the student
            $virtualAccountNumber = $this->generateVirtualAccountNumber($student->student_id, $paymentPeriodId);

            // Create the virtual account
            VirtualAccount::create([
                'invoice_id' => $invoice->id,
                'virtual_account_number' => $virtualAccountNumber,
                'expired_at' => Carbon::now()->addMonth(), // Add 1 month to the current date
                'is_active' => $request->is_active ?? true,
                'total_amount' => $totalInvoiceAmount,
            ]);
        }

        return response()->json(['message' => 'Virtual accounts and invoices created successfully']);
    }

    public function getStudentsByPaymentPeriod(Request $request, $paymentPeriodId)
    {
        // Fetch the payment period and institution
        $paymentPeriod = PaymentPeriod::with('institution')->findOrFail($paymentPeriodId);
        $institutionId = $paymentPeriod->institution_id;

        // Start the query for students belonging to the institution
        $query = Student::with(['invoices', 'invoices.invoiceItems.itemType']) // Adjusted eager loading for invoice items and itemType
            ->where('institution_id', $institutionId)
            ->whereHas('invoices', function ($invoiceQuery) use ($paymentPeriodId) {
                $invoiceQuery->where('payment_period_id', $paymentPeriodId);
            });

        // Apply filters if present
        if ($request->has('year')) {
            $query->where('year', $request->input('year'));
        }

        if ($request->has('major')) {
            $query->where('major', $request->input('major'));
        }

        // Return the filtered students with their invoices and item types
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
