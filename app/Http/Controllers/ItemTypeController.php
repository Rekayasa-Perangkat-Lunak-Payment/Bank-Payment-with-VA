<?php

namespace App\Http\Controllers;

use App\Models\ItemType;
use Illuminate\Http\Request;

class ItemTypeController extends Controller
{
    // List all item types
    public function index()
    {
        $itemTypes = ItemType::where('is_deleted', false)->get(); // You can exclude deleted items
        return response()->json($itemTypes);
    }

    // Store a new item type
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'institution_id' => 'required|exists:institutions,id', // Institution must exist
            'name' => 'required|string|max:255', // Name of the item type
            'description' => 'nullable|string|max:255', // Optional description
            'is_deleted' => 'required|boolean', // Make sure `is_deleted` is a boolean
        ]);

        // Create a new item type record
        $itemType = ItemType::create($validated);

        return response()->json([
            'message' => 'Item Type created successfully',
            'item_type' => $itemType
        ], 201);
    }

    // Show a specific item type
    public function show($id)
    {
        $itemType = ItemType::findOrFail($id);
        return response()->json($itemType);
    }

    // Update an existing item type
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'institution_id' => 'required|exists:institutions,id', // Institution must exist
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'is_deleted' => 'required|boolean',
        ]);

        // Find and update the item type
        $itemType = ItemType::findOrFail($id);
        $itemType->update($validated);

        return response()->json([
            'message' => 'Item Type updated successfully',
            'item_type' => $itemType
        ]);
    }

    // Delete a specific item type
    public function destroy($id)
    {
        $itemType = ItemType::findOrFail($id);
        $itemType->update(['is_deleted' => true]); // Soft delete by setting 'is_deleted' to true

        return response()->json([
            'message' => 'Item Type deleted successfully'
        ]);
    }
}
