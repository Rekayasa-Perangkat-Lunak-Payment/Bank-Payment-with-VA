<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // List all invoices
    public function index()
    {
        $invoices = Invoice::all();
        return response()->json($invoices);
    }

    // Store a new invoice
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id', // Assuming you have a 'students' table
            'payment_period_id' => 'required|exists:payment_periods,id', // Assuming you have a 'payment_periods' table
            'total_amount' => 'required|numeric|min:0', // Ensure the amount is a positive number
        ]);

        // Create a new invoice record
        $invoice = Invoice::create($validated);

        return response()->json([
            'message' => 'Invoice created successfully',
            'invoice' => $invoice
        ], 201);
    }

    // Show a specific invoice
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        return response()->json($invoice);
    }

    // Update an existing invoice
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'payment_period_id' => 'required|exists:payment_periods,id',
            'total_amount' => 'required|numeric|min:0',
        ]);

        // Find and update the invoice
        $invoice = Invoice::findOrFail($id);
        $invoice->update($validated);

        return response()->json([
            'message' => 'Invoice updated successfully',
            'invoice' => $invoice
        ]);
    }

    // Delete a specific invoice
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return response()->json([
            'message' => 'Invoice deleted successfully'
        ]);
    }
}
