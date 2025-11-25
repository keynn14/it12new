@extends('layouts.app')

@section('title', 'Create Material Issuance')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Material Issuance</h1>
    <a href="{{ route('material-issuance.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('material-issuance.store') }}" id="issuanceForm">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Project</label>
                    <select name="project_id" class="form-select">
                        <option value="">Select Project</option>
                        @foreach(\App\Models\Project::all() as $proj)
                            <option value="{{ $proj->id }}" {{ (request('project_id') == $proj->id || old('project_id') == $proj->id) ? 'selected' : '' }}>{{ $proj->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fabrication Job</label>
                    <select name="fabrication_job_id" class="form-select">
                        <option value="">Select Fabrication Job</option>
                        @foreach(\App\Models\FabricationJob::all() as $job)
                            <option value="{{ $job->id }}" {{ (request('fabrication_job_id') == $job->id || old('fabrication_job_id') == $job->id) ? 'selected' : '' }}>{{ $job->job_number }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Issuance Date *</label>
                    <input type="date" name="issuance_date" class="form-control" value="{{ old('issuance_date', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Purpose</label>
                    <input type="text" name="purpose" class="form-control" value="{{ old('purpose') }}">
                </div>
            </div>
            
            <h5>Items</h5>
            <div id="items-container">
                <div class="item-row mb-3 border p-3">
                    <div class="row">
                        <div class="col-md-5">
                            <label class="form-label">Item</label>
                            <select name="items[0][inventory_item_id]" class="form-select" required>
                                <option value="">Select Item</option>
                                @foreach(\App\Models\InventoryItem::where('status', 'active')->get() as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->item_code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Quantity</label>
                            <input type="number" step="0.01" name="items[0][quantity]" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Unit Cost</label>
                            <input type="number" step="0.01" name="items[0][unit_cost]" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Notes</label>
                            <input type="text" name="items[0][notes]" class="form-control">
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-danger w-100 remove-item"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            
            <button type="button" class="btn btn-secondary mb-3" id="add-item"><i class="bi bi-plus"></i> Add Item</button>
            
            <div class="mb-3">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Create Material Issuance</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let itemIndex = 1;
    document.getElementById('add-item').addEventListener('click', function() {
        const container = document.getElementById('items-container');
        const newRow = container.firstElementChild.cloneNode(true);
        newRow.querySelectorAll('input, select').forEach(el => {
            el.name = el.name.replace('[0]', `[${itemIndex}]`);
            if (el.type !== 'hidden') el.value = '';
        });
        container.appendChild(newRow);
        itemIndex++;
    });
    
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-item')) {
            if (document.getElementById('items-container').children.length > 1) {
                e.target.closest('.item-row').remove();
            }
        }
    });
</script>
@endpush
@endsection

