@extends('layouts.app')

@section('title', 'Create Purchase Request')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Purchase Request</h1>
    <a href="{{ route('purchase-requests.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('purchase-requests.store') }}" id="prForm">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Purpose</label>
                <textarea name="purpose" class="form-control" rows="2">{{ old('purpose') }}</textarea>
            </div>
            
            <h5>Items</h5>
            <div id="items-container">
                <div class="item-row mb-3 border p-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Item</label>
                            <select name="items[0][inventory_item_id]" class="form-select" required>
                                <option value="">Select Item</option>
                                @foreach(\App\Models\InventoryItem::where('status', 'active')->get() as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->item_code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Quantity</label>
                            <input type="number" step="0.01" name="items[0][quantity]" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Unit Cost</label>
                            <input type="number" step="0.01" name="items[0][unit_cost]" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Specifications</label>
                            <input type="text" name="items[0][specifications]" class="form-control">
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-danger w-100 remove-item"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            
            <button type="button" class="btn btn-secondary mb-3" id="add-item"><i class="bi bi-plus"></i> Add Item</button>
            
            <div class="mb-3">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Create Purchase Request</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let itemIndex = 1;
    document.getElementById('add-item').addEventListener('click', function() {
        const container = document.getElementById('items-container');
        const newRow = container.firstElementChild.cloneNode(true);
        newRow.querySelectorAll('input, select').forEach(el => {
            el.name = el.name.replace('[0]', `[${itemIndex}]`);
            if (el.type !== 'hidden') el.value = '';
        });
        container.appendChild(newRow);
        itemIndex++;
    });
    
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-item')) {
            if (document.getElementById('items-container').children.length > 1) {
                e.target.closest('.item-row').remove();
            }
        }
    });
</script>
@endpush
@endsection

