@extends('layouts.app')

@section('title', 'Goods Receipt Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Goods Receipt: {{ $goodsReceipt->gr_number }}</h1>
    <div>
        @if($goodsReceipt->status === 'pending')
            <form method="POST" action="{{ route('goods-receipts.approve', $goodsReceipt) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success">Approve & Update Stock</button>
            </form>
        @endif
        <a href="{{ route('goods-receipts.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Purchase Order:</strong> {{ $goodsReceipt->purchaseOrder->po_number }}</p>
                <p><strong>Supplier:</strong> {{ $goodsReceipt->purchaseOrder->supplier->name }}</p>
                <p><strong>GR Date:</strong> {{ $goodsReceipt->gr_date->format('Y-m-d') }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Status:</strong> <span class="badge bg-{{ $goodsReceipt->status === 'approved' ? 'success' : 'warning' }}">{{ ucfirst($goodsReceipt->status) }}</span></p>
                <p><strong>Received By:</strong> {{ $goodsReceipt->receivedBy->name ?? 'N/A' }}</p>
            </div>
        </div>
        
        <h5>Items</h5>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Ordered</th>
                        <th>Received</th>
                        <th>Accepted</th>
                        <th>Rejected</th>
                        <th>Rejection Reason</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($goodsReceipt->items as $item)
                        <tr>
                            <td>{{ $item->inventoryItem->name }}</td>
                            <td>{{ number_format($item->quantity_ordered, 2) }}</td>
                            <td>{{ number_format($item->quantity_received, 2) }}</td>
                            <td>{{ number_format($item->quantity_accepted, 2) }}</td>
                            <td>{{ number_format($item->quantity_rejected, 2) }}</td>
                            <td>{{ $item->rejection_reason ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

