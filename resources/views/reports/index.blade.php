@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-graph-up"></i> Reports</h1>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Inventory Movement</h5>
                <p class="card-text">View stock movements and inventory history</p>
                <a href="{{ route('reports.inventory-movement') }}" class="btn btn-primary">View Report</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Purchase History</h5>
                <p class="card-text">View purchase order history and statistics</p>
                <a href="{{ route('reports.purchase-history') }}" class="btn btn-primary">View Report</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Supplier Performance</h5>
                <p class="card-text">Analyze supplier performance metrics</p>
                <a href="{{ route('reports.supplier-performance') }}" class="btn btn-primary">View Report</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Delayed Projects</h5>
                <p class="card-text">View projects that are behind schedule</p>
                <a href="{{ route('reports.delayed-projects') }}" class="btn btn-primary">View Report</a>
            </div>
        </div>
    </div>
</div>
@endsection

