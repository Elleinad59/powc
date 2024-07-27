@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Flash messages -->
        @if (session('success'))
            <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif (session('error'))
            <div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Sorting and Sync Button -->
        <div class="d-flex justify-content-end mb-3">
            <!-- Sorting Options -->
            <form method="GET" action="{{ route('purchase_order.index') }}" class="form-inline">
                <div class="form-group mr-2">
                    <label for="sortOrder" class="mr-2">Sort by Date:</label>
                    <select name="sort" id="sortOrder" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option value="desc" {{ $sortOrder === 'desc' ? 'selected' : '' }}>Latest First</option>
                        <option value="asc" {{ $sortOrder === 'asc' ? 'selected' : '' }}>Oldest First</option>
                    </select>
                </div>
            </form>
            <!-- Button to trigger data synchronization -->
            <form action="{{ route('sync.data') }}" method="GET">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm">Synchronize Data</button>
            </form>
        </div>

        <!-- Table to display purchase orders -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>PO Number</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchaseOrders as $order)
                    <tr>
                        <td>{{ $order->po_number }}</td>
                        <td>{{ $order->date }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            <a href="{{ route('purchase_order.show', $order->purchase_order_id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('purchase_order.edit', $order->purchase_order_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination links -->
        <div class="d-flex justify-content-center">
            {{ $purchaseOrders->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/alerts.js') }}"></script>
@endsection
