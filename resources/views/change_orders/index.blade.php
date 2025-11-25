@extends('layouts.app')

@section('title', 'Change Orders')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Change Orders</h1>
    <a href="{{ route('change-orders.create') }}" class="btn btn-primary">New Change Order</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Change Order Number</th>
                        <th>Project</th>
                        <th>Description</th>
                        <th>Additional Days</th>
                        <th>Additional Cost</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($changeOrders as $co)
                        <tr>
                            <td>{{ $co->change_order_number }}</td>
                            <td>{{ $co->project->name }}</td>
                            <td>{{ Str::limit($co->description, 50) }}</td>
                            <td>{{ $co->additional_days }}</td>
                            <td>${{ number_format($co->additional_cost, 2) }}</td>
                            <td><span class="badge bg-{{ $co->status === 'approved' ? 'success' : 'warning' }}">{{ ucfirst($co->status) }}</span></td>
                            <td>
                                <a href="{{ route('change-orders.show', $co) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">No change orders found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $changeOrders->links() }}
    </div>
</div>
@endsection

