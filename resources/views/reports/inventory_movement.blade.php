@extends('layouts.app')

@section('title', 'Inventory Movement Report')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Inventory Movement Report</h1>
    <div>
        <a href="{{ route('reports.inventory-movement', array_merge(request()->all(), ['export' => 'pdf'])) }}" class="btn btn-danger">Export PDF</a>
        <a href="{{ route('reports.inventory-movement', array_merge(request()->all(), ['export' => 'csv'])) }}" class="btn btn-success">Export CSV</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Item</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Balance After</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $movement)
                        <tr>
                            <td>{{ $movement->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $movement->inventoryItem->name }}</td>
                            <td><span class="badge bg-{{ str_contains($movement->movement_type, 'in') ? 'success' : 'danger' }}">{{ ucfirst(str_replace('_', ' ', $movement->movement_type)) }}</span></td>
                            <td>{{ number_format($movement->quantity, 2) }}</td>
                            <td>{{ number_format($movement->balance_after, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No movements found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

