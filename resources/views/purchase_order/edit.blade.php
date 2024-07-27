@extends('layouts.app')

@section('title', 'Edit Purchase Order Items')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Purchase Order Items</h1>

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

    <!-- Edit PO Items Form -->
    <div class="card">
        <div class="card-header">
            Edit PO Items
        </div>
        <div class="card-body">
            <form action="{{ route('purchase_order.update', $purchaseOrder->purchase_order_id) }}" method="POST">
                @csrf
                @method('PUT')
                
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
                                <td>
                                    <select name="status[{{ $item->po_item_id }}]" class="form-control">
                                        <option value="In-process" {{ $item->status == 'In-process' ? 'selected' : '' }}>In-process</option>
                                        <option value="Shipped" {{ $item->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="Delivered" {{ $item->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                    </select>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No items found for this purchase order.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        </div>
    </div>
</div>
@endsection
