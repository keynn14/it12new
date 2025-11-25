@extends('layouts.app')

@section('title', 'Edit Fabrication Job')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Fabrication Job</h1>
    <a href="{{ route('fabrication.show', $fabricationJob) }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('fabrication.update', $fabricationJob) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Description *</label>
                <input type="text" name="description" class="form-control" value="{{ old('description', $fabricationJob->description) }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Specifications</label>
                <textarea name="specifications" class="form-control" rows="3">{{ old('specifications', $fabricationJob->specifications) }}</textarea>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Start Date *</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $fabricationJob->start_date->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Expected Completion Date *</label>
                    <input type="date" name="expected_completion_date" class="form-control" value="{{ old('expected_completion_date', $fabricationJob->expected_completion_date->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Actual Completion Date</label>
                    <input type="date" name="actual_completion_date" class="form-control" value="{{ old('actual_completion_date', $fabricationJob->actual_completion_date ? $fabricationJob->actual_completion_date->format('Y-m-d') : '') }}">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="planned" {{ old('status', $fabricationJob->status) == 'planned' ? 'selected' : '' }}>Planned</option>
                        <option value="in_progress" {{ old('status', $fabricationJob->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('status', $fabricationJob->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="on_hold" {{ old('status', $fabricationJob->status) == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                        <option value="cancelled" {{ old('status', $fabricationJob->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Progress %</label>
                    <input type="number" min="0" max="100" name="progress_percentage" class="form-control" value="{{ old('progress_percentage', $fabricationJob->progress_percentage) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Estimated Cost *</label>
                    <input type="number" step="0.01" name="estimated_cost" class="form-control" value="{{ old('estimated_cost', $fabricationJob->estimated_cost) }}" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Actual Cost</label>
                <input type="number" step="0.01" name="actual_cost" class="form-control" value="{{ old('actual_cost', $fabricationJob->actual_cost) }}">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Assigned To</label>
                <select name="assigned_to" class="form-select">
                    <option value="">Select User</option>
                    @foreach(\App\Models\User::all() as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to', $fabricationJob->assigned_to) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes', $fabricationJob->notes) }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Update Fabrication Job</button>
        </form>
    </div>
</div>
@endsection

