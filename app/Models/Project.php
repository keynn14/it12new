<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_code',
        'name',
        'description',
        'client_id',
        'project_manager_id',
        'start_date',
        'end_date',
        'actual_end_date',
        'status',
        'budget',
        'actual_cost',
        'progress_percentage',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'actual_end_date' => 'date',
            'budget' => 'decimal:2',
            'actual_cost' => 'decimal:2',
        ];
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function projectManager()
    {
        return $this->belongsTo(User::class, 'project_manager_id');
    }

    public function changeOrders()
    {
        return $this->hasMany(ChangeOrder::class);
    }

    public function purchaseRequests()
    {
        return $this->hasMany(PurchaseRequest::class);
    }

    public function materialIssuances()
    {
        return $this->hasMany(MaterialIssuance::class);
    }

    public function fabricationJobs()
    {
        return $this->hasMany(FabricationJob::class);
    }
}

