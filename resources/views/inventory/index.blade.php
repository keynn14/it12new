@extends('layouts.app')

@section('title', 'Inventory')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-boxes"></i> Inventory</h1>
    <a href="{{ route('inventory.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> New Item</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="item_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="raw_material" {{ request('item_type') == 'raw_material' ? 'selected' : '' }}>Raw Material</option>
                        <option value="finished_good" {{ request('item_type') == 'finished_good' ? 'selected' : '' }}>Finished Good</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Current Stock</th>
                        <th>Unit</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr class="{{ $item->needs_reorder ? 'table-warning' : '' }}">
                            <td>{{ $item->item_code }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->category ?? 'N/A' }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $item->item_type)) }}</td>
                            <td>
                                {{ number_format($item->current_stock, 2) }}
                                @if($item->needs_reorder)
                                    <span class="badge bg-danger">Low Stock</span>
                                @endif
                            </td>
                            <td>{{ $item->unit_of_measure }}</td>
                            <td><span class="badge bg-{{ $item->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($item->status) }}</span></td>
                            <td>
                                <a href="{{ route('inventory.show', $item) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('inventory.edit', $item) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center">No items found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    </div>
</div>
@endsection

