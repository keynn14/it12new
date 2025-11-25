@extends('layouts.app')

@section('title', 'Supplier Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $supplier->name }}</h1>
    <div>
        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table">
            <tr><th>Code:</th><td>{{ $supplier->code }}</td></tr>
            <tr><th>Contact Person:</th><td>{{ $supplier->contact_person ?? 'N/A' }}</td></tr>
            <tr><th>Email:</th><td>{{ $supplier->email ?? 'N/A' }}</td></tr>
            <tr><th>Phone:</th><td>{{ $supplier->phone ?? 'N/A' }}</td></tr>
            <tr><th>Address:</th><td>{{ $supplier->address ?? 'N/A' }}</td></tr>
            <tr><th>Status:</th><td><span class="badge bg-{{ $supplier->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($supplier->status) }}</span></td></tr>
        </table>
    </div>
</div>
@endsection

