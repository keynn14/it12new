@extends('layouts.app')

@section('title', 'Purchase Request Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Purchase Request: {{ $purchaseRequest->pr_number }}</h1>
    <div>
        @if($purchaseRequest->status === 'submitted')
            <form method="POST" action="{{ route('purchase-requests.approve', $purchaseRequest) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success">Approve</button>
            </form>
        @endif
        <a href="{{ route('purchase-requests.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5>Items</h5>
        <table class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Unit Cost</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchaseRequest->items as $item)
                    <tr>
                        <td>{{ $item->inventoryItem->name }}</td>
                        <td>{{ $item->quantity }} {{ $item->inventoryItem->unit_of_measure }}</td>
                        <td>${{ number_format($item->unit_cost, 2) }}</td>
                        <td>${{ number_format($item->quantity * $item->unit_cost, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <a href="{{ route('quotations.create', ['purchase_request_id' => $purchaseRequest->id]) }}" class="btn btn-primary">Create Quotation</a>
    </div>
</div>
@endsection

