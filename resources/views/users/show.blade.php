@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $user->name }}</h1>
    <div>
        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table">
            <tr><th>Name:</th><td>{{ $user->name }}</td></tr>
            <tr><th>Email:</th><td>{{ $user->email }}</td></tr>
            <tr><th>Role:</th><td><span class="badge bg-primary">{{ $user->role->name ?? 'No Role' }}</span></td></tr>
        </table>
    </div>
</div>
@endsection

