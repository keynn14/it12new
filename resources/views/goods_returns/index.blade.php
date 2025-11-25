@extends('layouts.app')

@section('title', 'Goods Returns')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-box-arrow-up"></i> Goods Returns</h1>
    <a href="{{ route('goods-returns.create') }}" class="btn btn-primary">New Return</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Return Number</th>
                        <th>Goods Receipt</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($goodsReturns as $return)
                        <tr>
                            <td>{{ $return->return_number }}</td>
                            <td>{{ $return->goodsReceipt->gr_number }}</td>
                            <td>{{ $return->return_date->format('Y-m-d') }}</td>
                            <td><span class="badge bg-{{ $return->status === 'approved' ? 'success' : 'warning' }}">{{ ucfirst($return->status) }}</span></td>
                            <td>
                                <a href="{{ route('goods-returns.show', $return) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No goods returns found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $goodsReturns->links() }}
    </div>
</div>
@endsection

