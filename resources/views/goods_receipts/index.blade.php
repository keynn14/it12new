@extends('layouts.app')

@section('title', 'Goods Receipts')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-box-arrow-in-down"></i> Goods Receipts</h1>
    <a href="{{ route('goods-receipts.create') }}" class="btn btn-primary">New Goods Receipt</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>GR Number</th>
                        <th>Purchase Order</th>
                        <th>Supplier</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($goodsReceipts as $gr)
                        <tr>
                            <td>{{ $gr->gr_number }}</td>
                            <td>{{ $gr->purchaseOrder->po_number }}</td>
                            <td>{{ $gr->purchaseOrder->supplier->name }}</td>
                            <td>{{ $gr->gr_date->format('Y-m-d') }}</td>
                            <td><span class="badge bg-{{ $gr->status === 'approved' ? 'success' : 'warning' }}">{{ ucfirst($gr->status) }}</span></td>
                            <td>
                                <a href="{{ route('goods-receipts.show', $gr) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">No goods receipts found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $goodsReceipts->links() }}
    </div>
</div>
@endsection

