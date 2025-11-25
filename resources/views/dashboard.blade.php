@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <div>
        <h1 class="h2 mb-1"><i class="bi bi-speedometer2"></i> Dashboard</h1>
        <p class="text-muted mb-0">Welcome back! Here's what's happening with your business today.</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-content">
                        <p class="stat-label">Total Projects</p>
                        <h2 class="stat-value">{{ $totalProjects }}</h2>
                        <small class="stat-change text-muted">All time</small>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-folder"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="stat-card stat-card-success">
            <div class="stat-card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-content">
                        <p class="stat-label">Active Projects</p>
                        <h2 class="stat-value">{{ $activeProjects }}</h2>
                        <small class="stat-change text-muted">In progress</small>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="stat-card stat-card-warning">
            <div class="stat-card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-content">
                        <p class="stat-label">Pending POs</p>
                        <h2 class="stat-value">{{ $pendingPOs }}</h2>
                        <small class="stat-change text-muted">Awaiting approval</small>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-cart"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="stat-card stat-card-danger">
            <div class="stat-card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-content">
                        <p class="stat-label">Low Stock Items</p>
                        <h2 class="stat-value">{{ $lowStockItems }}</h2>
                        <small class="stat-change text-muted">Needs attention</small>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="chart-card">
            <div class="chart-card-header">
                <h5 class="chart-title">Projects by Status</h5>
                <i class="bi bi-pie-chart chart-icon"></i>
            </div>
            <div class="chart-card-body">
                <canvas id="projectStatusChart"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="chart-card">
            <div class="chart-card-header">
                <h5 class="chart-title">Purchase Orders by Status</h5>
                <i class="bi bi-bar-chart chart-icon"></i>
            </div>
            <div class="chart-card-body">
                <canvas id="poStatusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <div class="col-md-4 mb-3">
        <div class="activity-card">
            <div class="activity-card-header">
                <h5 class="activity-title">Recent Projects</h5>
                <a href="{{ route('projects.index') }}" class="activity-link">View all <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="activity-card-body">
                @forelse($recentProjects as $project)
                    <a href="{{ route('projects.show', $project) }}" class="activity-item">
                        <div class="activity-item-content">
                            <div class="activity-item-header">
                                <h6 class="activity-item-title">{{ $project->name }}</h6>
                                <span class="badge badge-{{ $project->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($project->status) }}</span>
                            </div>
                            <p class="activity-item-meta">
                                <i class="bi bi-clock"></i> {{ $project->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <i class="bi bi-chevron-right activity-arrow"></i>
                    </a>
                @empty
                    <div class="activity-empty">
                        <i class="bi bi-inbox"></i>
                        <p>No projects yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="activity-card">
            <div class="activity-card-header">
                <h5 class="activity-title">Recent Purchase Orders</h5>
                <a href="{{ route('purchase-orders.index') }}" class="activity-link">View all <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="activity-card-body">
                @forelse($recentPOs as $po)
                    <a href="{{ route('purchase-orders.show', $po) }}" class="activity-item">
                        <div class="activity-item-content">
                            <div class="activity-item-header">
                                <h6 class="activity-item-title">{{ $po->po_number }}</h6>
                                <span class="badge badge-info">{{ $po->supplier->name ?? 'N/A' }}</span>
                            </div>
                            <p class="activity-item-meta">
                                <i class="bi bi-clock"></i> {{ $po->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <i class="bi bi-chevron-right activity-arrow"></i>
                    </a>
                @empty
                    <div class="activity-empty">
                        <i class="bi bi-inbox"></i>
                        <p>No purchase orders yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="activity-card">
            <div class="activity-card-header">
                <h5 class="activity-title">Recent Fabrication Jobs</h5>
                <a href="{{ route('fabrication.index') }}" class="activity-link">View all <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="activity-card-body">
                @forelse($recentFabricationJobs as $job)
                    <a href="{{ route('fabrication.show', $job) }}" class="activity-item">
                        <div class="activity-item-content">
                            <div class="activity-item-header">
                                <h6 class="activity-item-title">{{ $job->job_number }}</h6>
                                <span class="badge badge-primary">{{ Str::limit($job->description, 20) }}</span>
                            </div>
                            <p class="activity-item-meta">
                                <i class="bi bi-clock"></i> {{ $job->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <i class="bi bi-chevron-right activity-arrow"></i>
                    </a>
                @empty
                    <div class="activity-empty">
                        <i class="bi bi-inbox"></i>
                        <p>No fabrication jobs yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Stat Cards */
    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e5e7eb;
        overflow: hidden;
        position: relative;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--card-color), var(--card-color-light));
    }
    
    .stat-card-primary {
        --card-color: #2563eb;
        --card-color-light: #3b82f6;
    }
    
    .stat-card-success {
        --card-color: #10b981;
        --card-color-light: #34d399;
    }
    
    .stat-card-warning {
        --card-color: #f59e0b;
        --card-color-light: #fbbf24;
    }
    
    .stat-card-danger {
        --card-color: #ef4444;
        --card-color-light: #f87171;
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }
    
    .stat-card-body {
        padding: 1.5rem;
    }
    
    .stat-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #6b7280;
        margin: 0 0 0.5rem 0;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .stat-value {
        font-size: 2.25rem;
        font-weight: 700;
        color: #111827;
        margin: 0 0 0.25rem 0;
        line-height: 1;
    }
    
    .stat-change {
        font-size: 0.75rem;
        display: block;
    }
    
    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--card-color), var(--card-color-light));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 1.75rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    /* Chart Cards */
    .chart-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .chart-card:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    }
    
    .chart-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f9fafb;
    }
    
    .chart-title {
        font-size: 1rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }
    
    .chart-icon {
        color: #6b7280;
        font-size: 1.25rem;
    }
    
    .chart-card-body {
        padding: 1.5rem;
        height: 300px;
        position: relative;
    }
    
    /* Activity Cards */
    .activity-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .activity-card:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    }
    
    .activity-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f9fafb;
    }
    
    .activity-title {
        font-size: 1rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }
    
    .activity-link {
        font-size: 0.875rem;
        color: #2563eb;
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        transition: color 0.2s ease;
    }
    
    .activity-link:hover {
        color: #1d4ed8;
    }
    
    .activity-card-body {
        padding: 0.75rem;
    }
    
    .activity-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        border-radius: 12px;
        text-decoration: none;
        color: inherit;
        transition: all 0.2s ease;
        margin-bottom: 0.5rem;
    }
    
    .activity-item:hover {
        background: #f3f4f6;
        transform: translateX(4px);
    }
    
    .activity-item:last-child {
        margin-bottom: 0;
    }
    
    .activity-item-content {
        flex: 1;
    }
    
    .activity-item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    
    .activity-item-title {
        font-size: 0.9375rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }
    
    .activity-item-meta {
        font-size: 0.8125rem;
        color: #6b7280;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .activity-arrow {
        color: #9ca3af;
        font-size: 1.125rem;
        transition: transform 0.2s ease;
    }
    
    .activity-item:hover .activity-arrow {
        transform: translateX(4px);
        color: #2563eb;
    }
    
    .activity-empty {
        padding: 3rem 1.5rem;
        text-align: center;
        color: #9ca3af;
    }
    
    .activity-empty i {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        display: block;
    }
    
    .activity-empty p {
        margin: 0;
        font-size: 0.875rem;
    }
    
    /* Badges */
    .badge-success {
        background: #10b981;
        color: #ffffff;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-secondary {
        background: #6b7280;
        color: #ffffff;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-info {
        background: #3b82f6;
        color: #ffffff;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-primary {
        background: #2563eb;
        color: #ffffff;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>
@endpush

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
                backgroundColor: [
                    '#2563eb',
                    '#10b981',
                    '#f59e0b',
                    '#ef4444',
                    '#6b7280'
                ],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    cornerRadius: 8
                }
            }
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
                backgroundColor: 'rgba(37, 99, 235, 0.8)',
                borderColor: '#2563eb',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e5e7eb',
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        },
                        color: '#6b7280'
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        },
                        color: '#6b7280'
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection
