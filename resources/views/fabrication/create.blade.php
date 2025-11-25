@extends('layouts.app')

@section('title', 'Create Fabrication Job')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Fabrication Job</h1>
    <a href="{{ route('fabrication.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('fabrication.store') }}">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Project</label>
                    <select name="project_id" class="form-select">
                        <option value="">Select Project</option>
                        @foreach(\App\Models\Project::all() as $project)
                            <option value="{{ $project->id }}" {{ (request('project_id') == $project->id || old('project_id') == $project->id) ? 'selected' : '' }}>{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Assigned To</label>
                    <select name="assigned_to" class="form-select">
                        <option value="">Select User</option>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Description *</label>
                <input type="text" name="description" class="form-control" value="{{ old('description') }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Specifications</label>
                <textarea name="specifications" class="form-control" rows="3">{{ old('specifications') }}</textarea>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Start Date *</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Expected Completion Date *</label>
                    <input type="date" name="expected_completion_date" class="form-control" value="{{ old('expected_completion_date') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Estimated Cost *</label>
                    <input type="number" step="0.01" name="estimated_cost" class="form-control" value="{{ old('estimated_cost', 0) }}" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Create Fabrication Job</button>
        </form>
    </div>
</div>
@endsection

