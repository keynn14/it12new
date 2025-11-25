@extends('layouts.app')

@section('title', 'Purchase Orders')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-cart-check"></i> Purchase Orders</h1>
    <a href="{{ route('purchase-orders.create') }}" class="btn btn-primary">New PO</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>PO Number</th>
                        <th>Supplier</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchaseOrders as $po)
                        <tr>
                            <td>{{ $po->po_number }}</td>
                            <td>{{ $po->supplier->name }}</td>
                            <td>{{ $po->po_date->format('Y-m-d') }}</td>
                            <td>${{ number_format($po->total_amount, 2) }}</td>
                            <td><span class="badge bg-{{ $po->status === 'approved' ? 'success' : 'warning' }}">{{ ucfirst($po->status) }}</span></td>
                            <td>
                                <a href="{{ route('purchase-orders.show', $po) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('purchase-orders.print', $po) }}" class="btn btn-sm btn-secondary"><i class="bi bi-printer"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">No purchase orders found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $purchaseOrders->links() }}
    </div>
</div>
@endsection

