@extends('layouts.app')

@section('title', 'Fabrication Job Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Fabrication Job: {{ $fabricationJob->job_number }}</h1>
    <div>
        @if($fabricationJob->status === 'planned')
            <form method="POST" action="{{ route('fabrication.start', $fabricationJob) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success">Start Job</button>
            </form>
        @endif
        @if($fabricationJob->status === 'in_progress')
            <form method="POST" action="{{ route('fabrication.complete', $fabricationJob) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary">Complete Job</button>
            </form>
        @endif
        <a href="{{ route('fabrication.edit', $fabricationJob) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('fabrication.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header"><h5>Job Information</h5></div>
            <div class="card-body">
                <table class="table">
                    <tr><th>Job Number:</th><td>{{ $fabricationJob->job_number }}</td></tr>
                    <tr><th>Project:</th><td>{{ $fabricationJob->project->name ?? 'N/A' }}</td></tr>
                    <tr><th>Description:</th><td>{{ $fabricationJob->description }}</td></tr>
                    <tr><th>Status:</th><td><span class="badge bg-{{ $fabricationJob->status === 'completed' ? 'success' : ($fabricationJob->status === 'in_progress' ? 'primary' : 'secondary') }}">{{ ucfirst(str_replace('_', ' ', $fabricationJob->status)) }}</span></td></tr>
                    <tr><th>Progress:</th><td>
                        <div class="progress">
                            <div class="progress-bar" style="width: {{ $fabricationJob->progress_percentage }}%">{{ $fabricationJob->progress_percentage }}%</div>
                        </div>
                    </td></tr>
                    <tr><th>Start Date:</th><td>{{ $fabricationJob->start_date->format('Y-m-d') }}</td></tr>
                    <tr><th>Expected Completion:</th><td>{{ $fabricationJob->expected_completion_date->format('Y-m-d') }}</td></tr>
                    <tr><th>Estimated Cost:</th><td>${{ number_format($fabricationJob->estimated_cost, 2) }}</td></tr>
                    <tr><th>Actual Cost:</th><td>${{ number_format($fabricationJob->actual_cost, 2) }}</td></tr>
                </table>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header"><h5>Material Issuances</h5></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Issuance Number</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($fabricationJob->materialIssuances as $issuance)
                                <tr>
                                    <td>{{ $issuance->issuance_number }}</td>
                                    <td>{{ $issuance->issuance_date->format('Y-m-d') }}</td>
                                    <td>{{ $issuance->items->count() }} items</td>
                                    <td><span class="badge bg-{{ $issuance->status === 'issued' ? 'success' : 'warning' }}">{{ ucfirst($issuance->status) }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center">No material issuances</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h5>Quick Actions</h5></div>
            <div class="card-body">
                <a href="{{ route('material-issuance.create', ['fabrication_job_id' => $fabricationJob->id]) }}" class="btn btn-primary w-100 mb-2">Issue Materials</a>
            </div>
        </div>
    </div>
</div>
@endsection

