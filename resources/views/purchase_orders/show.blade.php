@extends('layouts.app')

@section('title', 'Purchase Order Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">PO: {{ $purchaseOrder->po_number }}</h1>
    <div>
        @if($purchaseOrder->status === 'pending')
            <form method="POST" action="{{ route('purchase-orders.approve', $purchaseOrder) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success">Approve</button>
            </form>
        @endif
        <a href="{{ route('purchase-orders.print', $purchaseOrder) }}" class="btn btn-secondary">Print</a>
        <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5>Items</h5>
        <table class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchaseOrder->items as $item)
                    <tr>
                        <td>{{ $item->inventoryItem->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->unit_price, 2) }}</td>
                        <td>${{ number_format($item->total_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total:</th>
                    <th>${{ number_format($purchaseOrder->total_amount, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

