@extends('layouts.app')

@section('title', 'Quotations')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-file-earmark-spreadsheet"></i> Quotations</h1>
    <a href="{{ route('quotations.create') }}" class="btn btn-primary">New Quotation</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
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
                            <td>{{ $quotation->quotation_number }}</td>
                            <td>{{ $quotation->purchaseRequest->pr_number ?? 'N/A' }}</td>
                            <td>{{ $quotation->supplier->name }}</td>
                            <td>{{ $quotation->quotation_date->format('Y-m-d') }}</td>
                            <td>${{ number_format($quotation->total_amount, 2) }}</td>
                            <td><span class="badge bg-{{ $quotation->status === 'accepted' ? 'success' : 'warning' }}">{{ ucfirst($quotation->status) }}</span></td>
                            <td>
                                <a href="{{ route('quotations.show', $quotation) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">No quotations found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $quotations->links() }}
    </div>
</div>
@endsection

