@extends('layouts.app')

@section('title', 'Material Issuance')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-box-arrow-right"></i> Material Issuance</h1>
    <a href="{{ route('material-issuance.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> New Issuance</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="issued" {{ request('status') == 'issued' ? 'selected' : '' }}>Issued</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
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
                        <th>Issuance Number</th>
                        <th>Project</th>
                        <th>Fabrication Job</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Requested By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($issuances as $issuance)
                        <tr>
                            <td>{{ $issuance->issuance_number }}</td>
                            <td>{{ $issuance->project->name ?? 'N/A' }}</td>
                            <td>{{ $issuance->fabricationJob->job_number ?? 'N/A' }}</td>
                            <td>{{ $issuance->issuance_date->format('Y-m-d') }}</td>
                            <td><span class="badge bg-{{ $issuance->status === 'issued' ? 'success' : ($issuance->status === 'approved' ? 'warning' : 'secondary') }}">{{ ucfirst($issuance->status) }}</span></td>
                            <td>{{ $issuance->requestedBy->name ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('material-issuance.show', $issuance) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">No material issuances found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $issuances->links() }}
    </div>
</div>
@endsection

