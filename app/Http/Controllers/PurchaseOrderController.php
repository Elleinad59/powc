<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan; // Add this line


class PurchaseOrderController extends Controller
{
    // Display a list of purchase orders with pagination
    public function index(Request $request)
    {
        // Determine the sort order from request, default to 'desc'
        $sortOrder = $request->input('sort', 'desc');

        // Fetch purchase orders with specified sorting and pagination
        $purchaseOrders = DB::connection('crm_1')->table('purchase_order')
            ->orderBy('date', $sortOrder) // Order by date
            ->paginate(10); // Adjust the number of items per page as needed

        return view('purchase_order.index', compact('purchaseOrders', 'sortOrder'));
    }

    // Show the purchase order details
    public function show($id)
    {
        // Fetch the purchase order
        $purchaseOrder = DB::connection('crm_1')->table('purchase_order')
            ->where('purchase_order_id', $id)
            ->first();
        
        // Fetch associated items and join with item_master to get item names
        $poItems = DB::connection('crm_1')->table('po_items')
            ->join('item_master', 'po_items.item', '=', 'item_master.item_id')
            ->where('po_items.po_id', $id)
            ->select('po_items.*', 'item_master.item_name')
            ->get();

        return view('purchase_order.show', compact('purchaseOrder', 'poItems'));
    }

    // Show the form for editing the status of PO items
    public function edit($id)
    {
        // Fetch the purchase order
        $purchaseOrder = DB::connection('crm_1')->table('purchase_order')
            ->where('purchase_order_id', $id)
            ->first();
    
        // Fetch associated items and join with item_master to get item names
        $poItems = DB::connection('crm_1')->table('po_items')
            ->join('item_master', 'po_items.item', '=', 'item_master.item_id')
            ->where('po_items.po_id', $id)
            ->select('po_items.*', 'item_master.item_name')
            ->get();
    
        return view('purchase_order.edit', compact('purchaseOrder', 'poItems'));
    }
    
    // Update the status of the PO items
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'status' => 'required|array',
            'status.*' => 'required|in:In-process,Shipped,Delivered',
        ]);

        // Update the status of each item
        foreach ($request->input('status') as $itemId => $status) {
            DB::connection('crm_1')->table('po_items')
                ->where('po_item_id', $itemId)
                ->update(['status' => $status]);
        }

        // Determine the new status of the purchase order
        $allStatuses = DB::connection('crm_1')->table('po_items')
            ->where('po_id', $id)
            ->pluck('status')
            ->toArray();

        if (in_array('In-process', $allStatuses)) {
            $purchaseOrderStatus = 'In-process';
        } elseif (in_array('Shipped', $allStatuses)) {
            $purchaseOrderStatus = 'Shipped';
        } else {
            $purchaseOrderStatus = 'Completed';
        }

        // Update the purchase order status
        DB::connection('crm_1')->table('purchase_order')
            ->where('purchase_order_id', $id)
            ->update(['status' => $purchaseOrderStatus]);

        return redirect()->route('purchase_order.show', $id)->with('success', 'PO items status updated successfully.');
    }

  
}
