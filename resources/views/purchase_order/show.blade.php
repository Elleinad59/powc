@extends('layouts.app')

@section('title', 'Purchase Order Details')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Purchase Order Details</h1>

    <!-- Purchase Order Details -->
    <div class="card mb-4">
        <div class="card-header">
            Purchase Order #{{ $purchaseOrder->po_number }}
        </div>
        <div class="card-body">
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($purchaseOrder->date)->format('Y-m-d') }}</p>
            <p><strong>Status:</strong> {{ $purchaseOrder->status }}</p>
        </div>
    </div>

    <!-- PO Items Table -->
    <div class="card">
        <div class="card-header">
            PO Items
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($poItems as $item)
                        <tr>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No items found for this purchase order.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <a href="{{ route('purchase_order.edit', $purchaseOrder->purchase_order_id) }}" class="btn btn-primary mt-3">Edit Items</a>
        </div>
    </div>
</div>
@endsection
