@extends('layouts.app')

@section('title', 'Create Goods Receipt')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Goods Receipt</h1>
    <a href="{{ route('goods-receipts.index') }}" class="btn btn-secondary">Back</a>
</div>

@if($purchaseOrder)
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('goods-receipts.store') }}" id="grForm">
            @csrf
            <input type="hidden" name="purchase_order_id" value="{{ $purchaseOrder->id }}">
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">GR Date *</label>
                    <input type="date" name="gr_date" class="form-control" value="{{ old('gr_date', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Delivery Note Number</label>
                    <input type="text" name="delivery_note_number" class="form-control" value="{{ old('delivery_note_number') }}">
                </div>
            </div>
            
            <h5>Items</h5>
            <div id="items-container">
                @foreach($purchaseOrder->items as $index => $poItem)
                    <div class="item-row mb-3 border p-3">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Item</label>
                                <input type="text" class="form-control" value="{{ $poItem->inventoryItem->name }}" readonly>
                                <input type="hidden" name="items[{{ $index }}][purchase_order_item_id]" value="{{ $poItem->id }}">
                                <input type="hidden" name="items[{{ $index }}][inventory_item_id]" value="{{ $poItem->inventory_item_id }}">
                                <input type="hidden" name="items[{{ $index }}][quantity_ordered]" value="{{ $poItem->quantity }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Ordered</label>
                                <input type="text" class="form-control" value="{{ $poItem->quantity }}" readonly>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Received *</label>
                                <input type="number" step="0.01" name="items[{{ $index }}][quantity_received]" class="form-control" value="{{ $poItem->quantity }}" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Accepted *</label>
                                <input type="number" step="0.01" name="items[{{ $index }}][quantity_accepted]" class="form-control" value="{{ $poItem->quantity }}" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Rejected</label>
                                <input type="number" step="0.01" name="items[{{ $index }}][quantity_rejected]" class="form-control" value="0">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">Rejection Reason</label>
                                <input type="text" name="items[{{ $index }}][rejection_reason]" class="form-control">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mb-3">
                <label class="form-label">Remarks</label>
                <textarea name="remarks" class="form-control" rows="2">{{ old('remarks') }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Create Goods Receipt</button>
        </form>
    </div>
</div>
@else
<div class="alert alert-info">
    Please select a purchase order to create a goods receipt from.
</div>
@endif
@endsection

