@extends('layouts.app')

@section('title', 'Quotations')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <div>
        <h1 class="h2 mb-1"><i class="bi bi-file-earmark-spreadsheet"></i> Quotations</h1>
        <p class="text-muted mb-0">Manage supplier quotations and pricing</p>
    </div>
    <a href="{{ route('quotations.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> New Quotation</a>
</div>

<div class="card quotation-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>Quotation Number</th>
                        <th>Purchase Request</th>
                        <th>Supplier</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotations as $quotation)
                        <tr>
                            <td><span class="text-muted font-monospace">{{ $quotation->quotation_number }}</span></td>
                            <td>
                                <div class="fw-semibold">{{ $quotation->purchaseRequest->pr_number ?? 'N/A' }}</div>
                            </td>
                            <td>{{ $quotation->supplier->name }}</td>
                            <td><span class="text-muted">{{ $quotation->quotation_date->format('M d, Y') }}</span></td>
                            <td><strong>₱{{ number_format($quotation->total_amount, 2) }}</strong></td>
                            <td>
                                <span class="badge badge-{{ $quotation->status === 'accepted' ? 'success' : ($quotation->status === 'pending' ? 'primary' : 'warning') }}">
                                    {{ ucfirst($quotation->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('quotations.show', $quotation) }}" class="btn btn-sm btn-action btn-view" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-file-earmark-x"></i>
                                    <p class="mt-3 mb-0">No quotations found</p>
                                    <small class="text-muted">Create your first quotation to get started</small>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-end mt-3">
            {{ $quotations->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@push('styles')
<style>
    .quotation-card {
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
    }
    
    .table-modern {
        margin-bottom: 0;
    }
    
    .table-modern thead th {
        background: #f9fafb;
        border-bottom: 2px solid #e5e7eb;
        font-weight: 600;
        color: #374151;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 1rem;
    }
    
    .table-modern tbody td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .table-modern tbody tr {
        transition: all 0.2s ease;
    }
    
    .table-modern tbody tr:hover {
        background: #f9fafb;
        transform: scale(1.001);
    }
    
    .btn-action {
        width: 36px;
        height: 36px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s ease;
        border: none;
    }
    
    .btn-view {
        background: #dbeafe;
        color: #2563eb;
    }
    
    .btn-view:hover {
        background: #2563eb;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
    }
    
    .badge-success {
        background: #10b981;
        color: #ffffff;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-primary {
        background: #2563eb;
        color: #ffffff;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-warning {
        background: #f59e0b;
        color: #ffffff;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .empty-state {
        padding: 2rem;
    }
    
    .empty-state i {
        font-size: 3rem;
        color: #9ca3af;
    }
    
    .empty-state p {
        font-size: 1.125rem;
        font-weight: 600;
        color: #374151;
    }
</style>
@endpush
@endsection
