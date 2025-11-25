@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-speedometer2"></i> Dashboard</h1>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Projects</h6>
                        <h2>{{ $totalProjects }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-folder fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Active Projects</h6>
                        <h2>{{ $activeProjects }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-check-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Pending POs</h6>
                        <h2>{{ $pendingPOs }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-cart fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Low Stock Items</h6>
                        <h2>{{ $lowStockItems }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-exclamation-triangle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Projects by Status</h5>
            </div>
            <div class="card-body">
                <canvas id="projectStatusChart" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Purchase Orders by Status</h5>
            </div>
            <div class="card-body">
                <canvas id="poStatusChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Projects</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @forelse($recentProjects as $project)
                        <a href="{{ route('projects.show', $project) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $project->name }}</h6>
                                <small>{{ $project->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1"><span class="badge bg-{{ $project->status === 'active' ? 'success' : 'secondary' }}">{{ $project->status }}</span></p>
                        </a>
                    @empty
                        <p class="text-muted">No projects yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Purchase Orders</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @forelse($recentPOs as $po)
                        <a href="{{ route('purchase-orders.show', $po) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $po->po_number }}</h6>
                                <small>{{ $po->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ $po->supplier->name ?? 'N/A' }}</p>
                        </a>
                    @empty
                        <p class="text-muted">No purchase orders yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Fabrication Jobs</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @forelse($recentFabricationJobs as $job)
                        <a href="{{ route('fabrication.show', $job) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $job->job_number }}</h6>
                                <small>{{ $job->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ $job->description }}</p>
                        </a>
                    @empty
                        <p class="text-muted">No fabrication jobs yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Project Status Chart
    const projectCtx = document.getElementById('projectStatusChart').getContext('2d');
    new Chart(projectCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($projectStatusData->toArray())) !!},
            datasets: [{
                data: {!! json_encode(array_values($projectStatusData->toArray())) !!},
                backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6c757d']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
    
    // PO Status Chart
    const poCtx = document.getElementById('poStatusChart').getContext('2d');
    new Chart(poCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($poStatusData->toArray())) !!},
            datasets: [{
                label: 'Purchase Orders',
                data: {!! json_encode(array_values($poStatusData->toArray())) !!},
                backgroundColor: '#0d6efd'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
@endsection

