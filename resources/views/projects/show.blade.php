@extends('layouts.app')

@section('title', 'Project Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-folder"></i> {{ $project->name }}</h1>
    <div>
        <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <h5>Project Information</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Project Code:</th>
                        <td>{{ $project->project_code }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td><span class="badge bg-{{ $project->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($project->status) }}</span></td>
                    </tr>
                    <tr>
                        <th>Client:</th>
                        <td>{{ $project->client->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Project Manager:</th>
                        <td>{{ $project->projectManager->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Start Date:</th>
                        <td>{{ $project->start_date->format('Y-m-d') }}</td>
                    </tr>
                    <tr>
                        <th>End Date:</th>
                        <td>{{ $project->end_date->format('Y-m-d') }}</td>
                    </tr>
                    <tr>
                        <th>Budget:</th>
                        <td>${{ number_format($project->budget, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Actual Cost:</th>
                        <td>${{ number_format($project->actual_cost, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Progress:</th>
                        <td>
                            <div class="progress">
                                <div class="progress-bar" style="width: {{ $project->progress_percentage }}%">{{ $project->progress_percentage }}%</div>
                            </div>
                        </td>
                    </tr>
                    @if($project->description)
                    <tr>
                        <th>Description:</th>
                        <td>{{ $project->description }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
        
        <div class="card mb-3">
            <div class="card-header">
                <h5>Change Orders</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('change-orders.create', ['project_id' => $project->id]) }}" class="btn btn-sm btn-primary mb-2">Add Change Order</a>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Description</th>
                                <th>Additional Days</th>
                                <th>Additional Cost</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($project->changeOrders as $co)
                                <tr>
                                    <td>{{ $co->change_order_number }}</td>
                                    <td>{{ Str::limit($co->description, 50) }}</td>
                                    <td>{{ $co->additional_days }}</td>
                                    <td>${{ number_format($co->additional_cost, 2) }}</td>
                                    <td><span class="badge bg-{{ $co->status === 'approved' ? 'success' : 'warning' }}">{{ ucfirst($co->status) }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center">No change orders</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h5>Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('purchase-requests.create', ['project_id' => $project->id]) }}" class="btn btn-primary w-100 mb-2">Create Purchase Request</a>
                <a href="{{ route('material-issuance.create', ['project_id' => $project->id]) }}" class="btn btn-primary w-100 mb-2">Issue Materials</a>
                <a href="{{ route('fabrication.create', ['project_id' => $project->id]) }}" class="btn btn-primary w-100 mb-2">Create Fabrication Job</a>
            </div>
        </div>
    </div>
</div>
@endsection

