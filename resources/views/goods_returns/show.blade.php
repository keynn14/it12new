@extends('layouts.app')

@section('title', 'Goods Return Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Goods Return: {{ $goodsReturn->return_number }}</h1>
    <div>
        @if($goodsReturn->status === 'pending')
            <form method="POST" action="{{ route('goods-returns.approve', $goodsReturn) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success">Approve & Update Stock</button>
            </form>
        @endif
        <a href="{{ route('goods-returns.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Goods Receipt:</strong> {{ $goodsReturn->goodsReceipt->gr_number }}</p>
                <p><strong>Return Date:</strong> {{ $goodsReturn->return_date->format('Y-m-d') }}</p>
                <p><strong>Reason:</strong> {{ $goodsReturn->reason }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Status:</strong> <span class="badge bg-{{ $goodsReturn->status === 'approved' ? 'success' : 'warning' }}">{{ ucfirst($goodsReturn->status) }}</span></p>
                <p><strong>Returned By:</strong> {{ $goodsReturn->returnedBy->name ?? 'N/A' }}</p>
            </div>
        </div>
        
        <h5>Items</h5>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($goodsReturn->items as $item)
                        <tr>
                            <td>{{ $item->inventoryItem->name }}</td>
                            <td>{{ number_format($item->quantity, 2) }}</td>
                            <td>{{ $item->reason ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

