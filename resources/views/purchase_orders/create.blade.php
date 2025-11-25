@extends('layouts.app')

@section('title', 'Create Purchase Order')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Purchase Order</h1>
    <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary">Back</a>
</div>

@if($quotation)
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('purchase-orders.store') }}">
            @csrf
            <input type="hidden" name="quotation_id" value="{{ $quotation->id }}">
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Supplier</label>
                    <input type="text" class="form-control" value="{{ $quotation->supplier->name }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Expected Delivery Date</label>
                    <input type="date" name="expected_delivery_date" class="form-control" value="{{ old('expected_delivery_date') }}">
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Delivery Address</label>
                <textarea name="delivery_address" class="form-control" rows="2">{{ old('delivery_address') }}</textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Terms & Conditions</label>
                <textarea name="terms_conditions" class="form-control" rows="3">{{ old('terms_conditions', $quotation->terms_conditions) }}</textarea>
            </div>
            
            <h5>Items from Quotation</h5>
            <div class="table-responsive mb-3">
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
            
            <button type="submit" class="btn btn-primary">Create Purchase Order</button>
        </form>
    </div>
</div>
@else
<div class="alert alert-info">
    Please select a quotation to create a purchase order from.
</div>
@endif
@endsection

