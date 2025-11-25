@extends('layouts.app')

@section('title', 'Create Inventory Item')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Inventory Item</h1>
    <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('inventory.store') }}">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Name *</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Item Type *</label>
                    <select name="item_type" class="form-select" required>
                        <option value="raw_material">Raw Material</option>
                        <option value="finished_good">Finished Good</option>
                        <option value="consumable">Consumable</option>
                        <option value="tool">Tool</option>
                    </select>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Unit of Measure *</label>
                    <input type="text" name="unit_of_measure" class="form-control" value="pcs" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Unit Cost *</label>
                    <input type="number" step="0.01" name="unit_cost" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="2"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Create Item</button>
        </form>
    </div>
</div>
@endsection

