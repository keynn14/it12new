@extends('layouts.app')

@section('title', 'Inventory Item Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $inventoryItem->name }}</h1>
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adjustStockModal">Adjust Stock</button>
        <a href="{{ route('inventory.edit', $inventoryItem) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><h5>Item Information</h5></div>
            <div class="card-body">
                <table class="table">
                    <tr><th>Code:</th><td>{{ $inventoryItem->item_code }}</td></tr>
                    <tr><th>Current Stock:</th><td><strong>{{ number_format($currentStock, 2) }} {{ $inventoryItem->unit_of_measure }}</strong></td></tr>
                    <tr><th>Unit Cost:</th><td>${{ number_format($inventoryItem->unit_cost, 2) }}</td></tr>
                    <tr><th>Reorder Level:</th><td>{{ number_format($inventoryItem->reorder_level, 2) }}</td></tr>
                    <tr><th>Type:</th><td>{{ ucfirst(str_replace('_', ' ', $inventoryItem->item_type)) }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h5>Stock Movements</h5></div>
            <div class="card-body">
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($movements as $movement)
                                <tr>
                                    <td>{{ $movement->created_at->format('Y-m-d H:i') }}</td>
                                    <td><span class="badge bg-{{ str_contains($movement->movement_type, 'in') ? 'success' : 'danger' }}">{{ ucfirst(str_replace('_', ' ', $movement->movement_type)) }}</span></td>
                                    <td>{{ number_format($movement->quantity, 2) }}</td>
                                    <td>{{ number_format($movement->balance_after, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $movements->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Adjust Stock Modal -->
<div class="modal fade" id="adjustStockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('inventory.adjust-stock', $inventoryItem) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Adjust Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Adjustment Type</label>
                        <select name="type" class="form-select" required>
                            <option value="adjustment_in">Stock In</option>
                            <option value="adjustment_out">Stock Out</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" step="0.01" name="quantity" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Adjust Stock</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

