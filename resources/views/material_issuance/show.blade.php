@extends('layouts.app')

@section('title', 'Material Issuance Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Material Issuance: {{ $materialIssuance->issuance_number }}</h1>
    <div>
        @if($materialIssuance->status === 'draft')
            <form method="POST" action="{{ route('material-issuance.approve', $materialIssuance) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success">Approve</button>
            </form>
        @endif
        @if($materialIssuance->status === 'approved')
            <form method="POST" action="{{ route('material-issuance.issue', $materialIssuance) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary">Issue Materials</button>
            </form>
        @endif
        <a href="{{ route('material-issuance.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header"><h5>Issuance Information</h5></div>
    <div class="card-body">
        <table class="table">
            <tr><th>Issuance Number:</th><td>{{ $materialIssuance->issuance_number }}</td></tr>
            <tr><th>Project:</th><td>{{ $materialIssuance->project->name ?? 'N/A' }}</td></tr>
            <tr><th>Fabrication Job:</th><td>{{ $materialIssuance->fabricationJob->job_number ?? 'N/A' }}</td></tr>
            <tr><th>Date:</th><td>{{ $materialIssuance->issuance_date->format('Y-m-d') }}</td></tr>
            <tr><th>Status:</th><td><span class="badge bg-{{ $materialIssuance->status === 'issued' ? 'success' : 'warning' }}">{{ ucfirst($materialIssuance->status) }}</span></td></tr>
            <tr><th>Purpose:</th><td>{{ $materialIssuance->purpose ?? 'N/A' }}</td></tr>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header"><h5>Items</h5></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Unit Cost</th>
                        <th>Total</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materialIssuance->items as $item)
                        <tr>
                            <td>{{ $item->inventoryItem->name }}</td>
                            <td>{{ number_format($item->quantity, 2) }} {{ $item->inventoryItem->unit_of_measure }}</td>
                            <td>${{ number_format($item->unit_cost, 2) }}</td>
                            <td>${{ number_format($item->quantity * $item->unit_cost, 2) }}</td>
                            <td>{{ $item->notes ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

