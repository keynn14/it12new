<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FabricationJob extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'job_number',
        'project_id',
        'description',
        'specifications',
        'start_date',
        'expected_completion_date',
        'actual_completion_date',
        'status',
        'progress_percentage',
        'estimated_cost',
        'actual_cost',
        'assigned_to',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'expected_completion_date' => 'date',
            'actual_completion_date' => 'date',
            'estimated_cost' => 'decimal:2',
            'actual_cost' => 'decimal:2',
        ];
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function materialIssuances()
    {
        return $this->hasMany(MaterialIssuance::class);
    }
}

