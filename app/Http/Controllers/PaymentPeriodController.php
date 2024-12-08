<?php

namespace App\Http\Controllers;

use App\Models\PaymentPeriod;
use Illuminate\Http\Request;

class PaymentPeriodController extends Controller
{
    // List all payment periods
    public function index(Request $request)
    {
        // Ambil parameter pencarian dan filter
        $semester = $request->input('semester');
        $year = $request->input('year');
        $institutionName = $request->input('institution_name');

        // Mulai query untuk PaymentPeriod
        $query = PaymentPeriod::where('is_deleted', false);

        // Filter berdasarkan semester jika ada
        if ($semester) {
            $query->where('semester', $semester);
        }

        // Filter berdasarkan tahun jika ada
        if ($year) {
            $query->where('year', $year);
        }

        // Filter berdasarkan nama institusi jika ada
        if ($institutionName) {
            $query->whereHas('institution', function ($query) use ($institutionName) {
                $query->where('name', 'like', '%' . $institutionName . '%');
            });
        }

        // Eager load relasi 'institution' untuk mendapatkan detail institusi
        $paymentPeriods = $query->with('institution', function ($query) {
            $query->select('id', 'name', 'status', 'educational_level');
        })->get();

        // Kembalikan hasil query dalam bentuk JSON
        return response()->json($paymentPeriods);
    }


    // Store a new payment period
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'institution_id' => 'required|exists:institutions,id', // Institution must exist
            'year' => 'required|integer|min:1900|max:3000', // Valid year range
            'month' => 'required|integer|min:1|max:12', // Valid month range (1-12)
            'semester' => 'required|string',
            'fixed_cost' => 'required|numeric|min:0', // Ensure fixed cost is a positive number
            'credit_cost' => 'required|numeric|min:0', // Ensure credit cost is a positive number
        ]);

        // Create a new payment period record
        $paymentPeriod = PaymentPeriod::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Payment period created successfully',
            'payment_period' => $paymentPeriod
        ], 201);
    }

    // Show a specific payment period
    public function show($id)
    {
        $paymentPeriod = PaymentPeriod::with('institution:id,name,status,educational_level')->findOrFail($id);
        return response()->json($paymentPeriod);
    }

    // Update an existing payment period
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'institution_id' => 'required|exists:institutions,id', // Institution must exist
            'year' => 'required|integer|min:1900|max:2099',
            'month' => 'required|integer|min:1|max:12',
            'semester' => 'required|integer|min:1|max:2',
            'fixed_cost' => 'required|numeric|min:0',
            'credit_cost' => 'required|numeric|min:0',
            'is_deleted' => 'required|boolean',
        ]);

        // Find and update the payment period
        $paymentPeriod = PaymentPeriod::findOrFail($id);
        $paymentPeriod->update($validated);

        return response()->json([
            'message' => 'Payment period updated successfully',
            'payment_period' => $paymentPeriod
        ]);
    }

    // Delete a specific payment period (soft delete)
    public function destroy($id)
    {
        $paymentPeriod = PaymentPeriod::findOrFail($id);
        $paymentPeriod->update(['is_deleted' => true]); // Soft delete by setting 'is_deleted' to true

        return response()->json([
            'message' => 'Payment period deleted successfully'
        ]);
    }
}
