<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AuditLogService
{
    /**
     * Log an action on a model
     */
    public function log(
        string $action,
        Model $model,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null
    ): AuditLog {
        $request = request();
        
        return AuditLog::create([
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'action' => $action,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'description' => $description,
        ]);
    }

    /**
     * Log a created action
     */
    public function logCreated(Model $model, ?string $description = null): AuditLog
    {
        return $this->log('created', $model, null, $model->getAttributes(), $description);
    }

    /**
     * Log an updated action
     */
    public function logUpdated(Model $model, array $oldValues, ?string $description = null): AuditLog
    {
        $newValues = array_intersect_key($model->getAttributes(), $oldValues);
        return $this->log('updated', $model, $oldValues, $newValues, $description);
    }

    /**
     * Log a deleted action
     */
    public function logDeleted(Model $model, ?string $description = null): AuditLog
    {
        return $this->log('deleted', $model, $model->getAttributes(), null, $description);
    }

    /**
     * Log a restored action (for soft deletes)
     */
    public function logRestored(Model $model, ?string $description = null): AuditLog
    {
        return $this->log('restored', $model, null, $model->getAttributes(), $description);
    }

    /**
     * Log a custom action
     */
    public function logAction(
        string $action,
        Model $model,
        ?string $description = null,
        ?array $additionalData = null
    ): AuditLog {
        return $this->log($action, $model, null, $additionalData, $description);
    }

    /**
     * Log approval actions
     */
    public function logApproved(Model $model, ?string $description = null): AuditLog
    {
        return $this->log('approved', $model, null, ['status' => 'approved'], $description);
    }

    /**
     * Log rejection actions
     */
    public function logRejected(Model $model, ?string $reason = null): AuditLog
    {
        return $this->log('rejected', $model, null, ['status' => 'rejected', 'reason' => $reason], $reason);
    }

    /**
     * Log cancellation actions
     */
    public function logCancelled(Model $model, ?string $reason = null): AuditLog
    {
        return $this->log('cancelled', $model, null, ['status' => 'cancelled', 'reason' => $reason], $reason);
    }

    /**
     * Log stock adjustments
     */
    public function logStockAdjustment(Model $model, array $adjustmentData, ?string $description = null): AuditLog
    {
        return $this->log('stock_adjusted', $model, null, $adjustmentData, $description);
    }
}

