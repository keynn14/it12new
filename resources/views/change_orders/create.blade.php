@extends('layouts.app')

@section('title', 'Create Change Order')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Change Order</h1>
    <a href="{{ route('change-orders.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('change-orders.store') }}">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Project *</label>
                <select name="project_id" class="form-select" required>
                    <option value="">Select Project</option>
                    @foreach(\App\Models\Project::all() as $proj)
                        <option value="{{ $proj->id }}" {{ (request('project_id') == $proj->id || old('project_id') == $proj->id) ? 'selected' : '' }}>{{ $proj->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Description *</label>
                <textarea name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Reason *</label>
                <textarea name="reason" class="form-control" rows="3" required>{{ old('reason') }}</textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Additional Days *</label>
                    <input type="number" name="additional_days" class="form-control" value="{{ old('additional_days', 0) }}" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Additional Cost *</label>
                    <input type="number" step="0.01" name="additional_cost" class="form-control" value="{{ old('additional_cost', 0) }}" min="0" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Approval Notes</label>
                <textarea name="approval_notes" class="form-control" rows="2">{{ old('approval_notes') }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Create Change Order</button>
        </form>
    </div>
</div>
@endsection

