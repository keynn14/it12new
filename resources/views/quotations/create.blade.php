@extends('layouts.app')

@section('title', 'Create Quotation')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Quotation</h1>
    <a href="{{ route('quotations.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('quotations.store') }}" id="quotationForm">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Purchase Request *</label>
                    <select name="purchase_request_id" class="form-select" required id="pr-select">
                        <option value="">Select Purchase Request</option>
                        @foreach(\App\Models\PurchaseRequest::where('status', 'approved')->get() as $pr)
                            <option value="{{ $pr->id }}" {{ (request('purchase_request_id') == $pr->id || old('purchase_request_id') == $pr->id) ? 'selected' : '' }}>{{ $pr->pr_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Supplier *</label>
                    <select name="supplier_id" class="form-select" required>
                        <option value="">Select Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Quotation Date *</label>
                    <input type="date" name="quotation_date" class="form-control" value="{{ old('quotation_date', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Valid Until *</label>
                    <input type="date" name="valid_until" class="form-control" value="{{ old('valid_until') }}" required>
                </div>
            </div>
            
            <h5>Items</h5>
            <div id="items-container">
                @if($purchaseRequest)
                    @foreach($purchaseRequest->items as $index => $prItem)
                        <div class="item-row mb-3 border p-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Item</label>
                                    <input type="text" class="form-control" value="{{ $prItem->inventoryItem->name }}" readonly>
                                    <input type="hidden" name="items[{{ $index }}][inventory_item_id]" value="{{ $prItem->inventory_item_id }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" step="0.01" name="items[{{ $index }}][quantity]" class="form-control" value="{{ $prItem->quantity }}" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Unit Price *</label>
                                    <input type="number" step="0.01" name="items[{{ $index }}][unit_price]" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Specifications</label>
                                    <input type="text" name="items[{{ $index }}][specifications]" class="form-control" value="{{ $prItem->specifications }}">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="button" class="btn btn-danger w-100 remove-item"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">Select a Purchase Request to load items</p>
                @endif
            </div>
            
            <div class="mb-3">
                <label class="form-label">Terms & Conditions</label>
                <textarea name="terms_conditions" class="form-control" rows="3">{{ old('terms_conditions') }}</textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Create Quotation</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('pr-select').addEventListener('change', function() {
        if (this.value) {
            window.location.href = '{{ route("quotations.create") }}?purchase_request_id=' + this.value;
        }
    });
</script>
@endpush
@endsection

