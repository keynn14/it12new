@extends('layouts.app')

@section('title', 'Change Order Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Change Order: {{ $changeOrder->change_order_number }}</h1>
    <div>
        @if($changeOrder->status === 'pending')
            <form method="POST" action="{{ route('change-orders.approve', $changeOrder) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success">Approve</button>
            </form>
            <form method="POST" action="{{ route('change-orders.reject', $changeOrder) }}" class="d-inline">
                @csrf
                <div class="input-group">
                    <input type="text" name="rejection_reason" class="form-control" placeholder="Rejection reason" required>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        @endif
        <a href="{{ route('change-orders.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table">
            <tr><th>Change Order Number:</th><td>{{ $changeOrder->change_order_number }}</td></tr>
            <tr><th>Project:</th><td>{{ $changeOrder->project->name }}</td></tr>
            <tr><th>Description:</th><td>{{ $changeOrder->description }}</td></tr>
            <tr><th>Reason:</th><td>{{ $changeOrder->reason }}</td></tr>
            <tr><th>Additional Days:</th><td>{{ $changeOrder->additional_days }}</td></tr>
            <tr><th>Additional Cost:</th><td>${{ number_format($changeOrder->additional_cost, 2) }}</td></tr>
            <tr><th>Status:</th><td><span class="badge bg-{{ $changeOrder->status === 'approved' ? 'success' : ($changeOrder->status === 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($changeOrder->status) }}</span></td></tr>
            @if($changeOrder->approval_notes)
            <tr><th>Approval Notes:</th><td>{{ $changeOrder->approval_notes }}</td></tr>
            @endif
        </table>
    </div>
</div>
@endsection

