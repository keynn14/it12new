@extends('layouts.app')

@section('title', 'Edit Inventory Item')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Inventory Item</h1>
    <a href="{{ route('inventory.show', $inventoryItem) }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('inventory.update', $inventoryItem) }}">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $inventoryItem->name) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Item Type *</label>
                    <select name="item_type" class="form-select" required>
                        <option value="raw_material" {{ old('item_type', $inventoryItem->item_type) == 'raw_material' ? 'selected' : '' }}>Raw Material</option>
                        <option value="finished_good" {{ old('item_type', $inventoryItem->item_type) == 'finished_good' ? 'selected' : '' }}>Finished Good</option>
                        <option value="consumable" {{ old('item_type', $inventoryItem->item_type) == 'consumable' ? 'selected' : '' }}>Consumable</option>
                        <option value="tool" {{ old('item_type', $inventoryItem->item_type) == 'tool' ? 'selected' : '' }}>Tool</option>
                    </select>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Unit of Measure *</label>
                    <input type="text" name="unit_of_measure" class="form-control" value="{{ old('unit_of_measure', $inventoryItem->unit_of_measure) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Unit Cost *</label>
                    <input type="number" step="0.01" name="unit_cost" class="form-control" value="{{ old('unit_cost', $inventoryItem->unit_cost) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="active" {{ old('status', $inventoryItem->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $inventoryItem->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="2">{{ old('description', $inventoryItem->description) }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Update Item</button>
        </form>
    </div>
</div>
@endsection

