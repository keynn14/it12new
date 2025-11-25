@extends('layouts.app')

@section('title', 'Quotation Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Quotation: {{ $quotation->quotation_number }}</h1>
    <div>
        <a href="{{ route('purchase-orders.create', ['quotation_id' => $quotation->id]) }}" class="btn btn-success">Create Purchase Order</a>
        <a href="{{ route('quotations.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Supplier:</strong> {{ $quotation->supplier->name }}</p>
                <p><strong>Quotation Date:</strong> {{ $quotation->quotation_date->format('Y-m-d') }}</p>
                <p><strong>Valid Until:</strong> {{ $quotation->valid_until->format('Y-m-d') }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Status:</strong> <span class="badge bg-{{ $quotation->status === 'accepted' ? 'success' : 'warning' }}">{{ ucfirst($quotation->status) }}</span></p>
                <p><strong>Total Amount:</strong> ${{ number_format($quotation->total_amount, 2) }}</p>
            </div>
        </div>
        
        <h5>Items</h5>
        <div class="table-responsive">
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
                    @foreach($quotation->items as $item)
                        <tr>
                            <td>{{ $item->inventoryItem->name }}</td>
                            <td>{{ number_format($item->quantity, 2) }}</td>
                            <td>${{ number_format($item->unit_price, 2) }}</td>
                            <td>${{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total:</th>
                        <th>${{ number_format($quotation->total_amount, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

