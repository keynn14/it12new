@extends('layouts.app')

@section('title', 'Fabrication Jobs')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-tools"></i> Fabrication Jobs</h1>
    <a href="{{ route('fabrication.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> New Job</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Job Number</th>
                        <th>Project</th>
                        <th>Description</th>
                        <th>Start Date</th>
                        <th>Expected Completion</th>
                        <th>Status</th>
                        <th>Progress</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $job)
                        <tr>
                            <td>{{ $job->job_number }}</td>
                            <td>{{ $job->project->name ?? 'N/A' }}</td>
                            <td>{{ Str::limit($job->description, 50) }}</td>
                            <td>{{ $job->start_date->format('Y-m-d') }}</td>
                            <td>{{ $job->expected_completion_date->format('Y-m-d') }}</td>
                            <td><span class="badge bg-{{ $job->status === 'completed' ? 'success' : ($job->status === 'in_progress' ? 'primary' : 'secondary') }}">{{ ucfirst(str_replace('_', ' ', $job->status)) }}</span></td>
                            <td>
                                <div class="progress" style="width: 100px;">
                                    <div class="progress-bar" style="width: {{ $job->progress_percentage }}%">{{ $job->progress_percentage }}%</div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('fabrication.show', $job) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('fabrication.edit', $job) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center">No fabrication jobs found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $jobs->links() }}
    </div>
</div>
@endsection

