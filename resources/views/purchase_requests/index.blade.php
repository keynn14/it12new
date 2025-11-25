@extends('layouts.app')

@section('title', 'Purchase Requests')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-file-earmark-text"></i> Purchase Requests</h1>
    <a href="{{ route('purchase-requests.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> New PR</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>PR Number</th>
                        <th>Project</th>
                        <th>Requested By</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchaseRequests as $pr)
                        <tr>
                            <td>{{ $pr->pr_number }}</td>
                            <td>{{ $pr->project->name ?? 'N/A' }}</td>
                            <td>{{ $pr->requestedBy->name ?? 'N/A' }}</td>
                            <td><span class="badge bg-{{ $pr->status === 'approved' ? 'success' : 'warning' }}">{{ ucfirst($pr->status) }}</span></td>
                            <td>{{ $pr->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('purchase-requests.show', $pr) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">No purchase requests found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $purchaseRequests->links() }}
    </div>
</div>
@endsection

