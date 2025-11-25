@extends('layouts.app')

@section('title', 'Create Goods Return')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Goods Return</h1>
    <a href="{{ route('goods-returns.index') }}" class="btn btn-secondary">Back</a>
</div>

@if($goodsReceipt)
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('goods-returns.store') }}">
            @csrf
            <input type="hidden" name="goods_receipt_id" value="{{ $goodsReceipt->id }}">
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Return Date *</label>
                    <input type="date" name="return_date" class="form-control" value="{{ old('return_date', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Reason *</label>
                    <input type="text" name="reason" class="form-control" value="{{ old('reason') }}" required>
                </div>
            </div>
            
            <h5>Items to Return</h5>
            <div id="items-container">
                @foreach($goodsReceipt->items as $index => $grItem)
                    <div class="item-row mb-3 border p-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Item</label>
                                <input type="text" class="form-control" value="{{ $grItem->inventoryItem->name }}" readonly>
                                <input type="hidden" name="items[{{ $index }}][goods_receipt_item_id]" value="{{ $grItem->id }}">
                                <input type="hidden" name="items[{{ $index }}][inventory_item_id]" value="{{ $grItem->inventory_item_id }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Accepted Qty</label>
                                <input type="text" class="form-control" value="{{ $grItem->quantity_accepted }}" readonly>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Return Qty *</label>
                                <input type="number" step="0.01" name="items[{{ $index }}][quantity]" class="form-control" max="{{ $grItem->quantity_accepted }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Reason</label>
                                <input type="text" name="items[{{ $index }}][reason]" class="form-control">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mb-3">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Create Goods Return</button>
        </form>
    </div>
</div>
@else
<div class="alert alert-info">
    Please select a goods receipt to create a return from.
</div>
@endif
@endsection

