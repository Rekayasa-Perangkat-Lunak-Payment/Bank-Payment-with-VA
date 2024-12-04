<?php

namespace App\Http\Controllers;

use App\Models\InvoiceItem;
use App\Models\ItemType;
use Illuminate\Http\Request;

class InvoiceItemController extends Controller
{
    // List all invoice items for a given invoice
    public function index($invoiceId)
    {
        $invoiceItems = InvoiceItem::where('invoice_id', $invoiceId)->get();
        return response()->json($invoiceItems);
    }

    // Store a new invoice item
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id', // Invoice must exist
            'item_type_id' => 'required|exists:item_types,id', // Item type must exist
            'quantity' => 'required|numeric|min:1', // Quantity must be at least 1
            'description' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
        ]);

        // Calculate the total price (quantity * unit_price)
        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];

        // Create a new invoice item
        $invoiceItem = InvoiceItem::create($validated);

        return response()->json([
            'message' => 'Invoice item created successfully',
            'invoice_item' => $invoiceItem
        ], 201);
    }

    // Show a specific invoice item
    public function show($id)
    {
        $invoiceItem = InvoiceItem::findOrFail($id);
        return response()->json($invoiceItem);
    }

    // Update an existing invoice item
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'item_type_id' => 'required|exists:item_types,id', // Item type must exist
            'quantity' => 'required|numeric|min:1', // Quantity must be at least 1
            'unit_price' => 'required|numeric|min:0', // Unit price must be positive
        ]);

        // Calculate the total price (quantity * unit_price)
        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];

        // Find and update the invoice item
        $invoiceItem = InvoiceItem::findOrFail($id);
        $invoiceItem->update($validated);

        return response()->json([
            'message' => 'Invoice item updated successfully',
            'invoice_item' => $invoiceItem
        ]);
    }

    // Delete a specific invoice item
    public function destroy($id)
    {
        $invoiceItem = InvoiceItem::findOrFail($id);
        $invoiceItem->delete();

        return response()->json([
            'message' => 'Invoice item deleted successfully'
        ]);
    }
}
