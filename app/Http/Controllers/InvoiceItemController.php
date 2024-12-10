<?php

namespace App\Http\Controllers;

use App\Models\InvoiceItem;
use App\Models\ItemType;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InvoiceItemController extends Controller
{
    // List all invoice items for a given invoice
    public function index($invoiceId)
    {
        try {
            $invoiceItems = InvoiceItem::where('invoice_id', $invoiceId)
                ->with('itemType') // Load related item type
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $invoiceItems
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve invoice items',
            ], 500);
        }
    }

    // Store a new invoice item
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'item_type_id' => 'required|exists:item_types,id',
            'quantity' => 'required|numeric|min:1',
            'unit_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ], [
            'invoice_id.required' => 'Invoice ID is required.',
            'item_type_id.required' => 'Item Type is required.',
            'quantity.min' => 'Quantity must be at least 1.',
            'unit_price.min' => 'Unit price must be at least 0.',
        ]);

        try {
            // Calculate the total price
            $validated['price'] = $validated['quantity'] * $validated['unit_price'];

            $invoiceItem = InvoiceItem::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Invoice item created successfully',
                'data' => $invoiceItem,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create invoice item',
            ], 500);
        }
    }

    // Show a specific invoice item
    public function show($id)
    {
        try {
            $invoiceItem = InvoiceItem::with('itemType')->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => $invoiceItem,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invoice item not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve invoice item',
            ], 500);
        }
    }

    // Update an existing invoice item
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'item_type_id' => 'required|exists:item_types,id',
            'quantity' => 'required|numeric|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        try {
            $invoiceItem = InvoiceItem::findOrFail($id);

            // Calculate the total price
            $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];

            $invoiceItem->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Invoice item updated successfully',
                'data' => $invoiceItem,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invoice item not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update invoice item',
            ], 500);
        }
    }

    // Delete a specific invoice item
    public function destroy($id)
    {
        try {
            $invoiceItem = InvoiceItem::findOrFail($id);
            $invoiceItem->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Invoice item deleted successfully',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invoice item not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete invoice item',
            ], 500);
        }
    }
}
