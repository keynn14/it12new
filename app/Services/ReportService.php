<?php

namespace App\Services;

use App\Models\Project;
use App\Models\StockMovement;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\InventoryItem;
use App\Models\MaterialIssuance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportService
{
    public function getInventoryMovementReport(array $filters = [])
    {
        $query = StockMovement::with(['inventoryItem', 'createdBy']);

        if (isset($filters['item_id'])) {
            $query->where('inventory_item_id', $filters['item_id']);
        }

        if (isset($filters['movement_type'])) {
            $query->where('movement_type', $filters['movement_type']);
        }

        if (isset($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function getPurchaseHistoryReport(array $filters = [])
    {
        $query = PurchaseOrder::with(['supplier', 'items.inventoryItem']);

        if (isset($filters['supplier_id'])) {
            $query->where('supplier_id', $filters['supplier_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['date_from'])) {
            $query->whereDate('po_date', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->whereDate('po_date', '<=', $filters['date_to']);
        }

        return $query->orderBy('po_date', 'desc')->get();
    }

    public function getProjectConsumptionReport(int $projectId, array $filters = [])
    {
        $query = MaterialIssuance::with(['items.inventoryItem'])
            ->where('project_id', $projectId)
            ->where('status', 'issued');

        if (isset($filters['date_from'])) {
            $query->whereDate('issuance_date', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->whereDate('issuance_date', '<=', $filters['date_to']);
        }

        return $query->orderBy('issuance_date', 'desc')->get();
    }

    public function getSupplierPerformanceReport(array $filters = [])
    {
        $query = Supplier::with(['purchaseOrders' => function ($q) use ($filters) {
            if (isset($filters['date_from'])) {
                $q->whereDate('po_date', '>=', $filters['date_from']);
            }
            if (isset($filters['date_to'])) {
                $q->whereDate('po_date', '<=', $filters['date_to']);
            }
        }]);

        $suppliers = $query->get();

        return $suppliers->map(function ($supplier) {
            $orders = $supplier->purchaseOrders;
            $totalOrders = $orders->count();
            $totalAmount = $orders->sum('total_amount');
            $completedOrders = $orders->where('status', 'completed')->count();
            $onTimeDeliveries = $orders->filter(function ($po) {
                if (!$po->expected_delivery_date) return false;
                $lastGR = $po->goodsReceipts()->latest()->first();
                if (!$lastGR) return false;
                return $lastGR->gr_date <= $po->expected_delivery_date;
            })->count();

            return [
                'supplier' => $supplier,
                'total_orders' => $totalOrders,
                'total_amount' => $totalAmount,
                'completed_orders' => $completedOrders,
                'on_time_deliveries' => $onTimeDeliveries,
                'on_time_rate' => $totalOrders > 0 ? ($onTimeDeliveries / $totalOrders) * 100 : 0,
            ];
        });
    }

    public function getDelayedProjectsReport()
    {
        $today = Carbon::today();

        return Project::where('status', 'active')
            ->where('end_date', '<', $today)
            ->whereNull('actual_end_date')
            ->with(['projectManager', 'client'])
            ->orderBy('end_date', 'asc')
            ->get()
            ->map(function ($project) use ($today) {
                $daysDelayed = $today->diffInDays($project->end_date);
                return [
                    'project' => $project,
                    'days_delayed' => $daysDelayed,
                ];
            });
    }

    public function exportToCsv($data, $filename)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            
            if (count($data) > 0) {
                // Write headers
                fputcsv($file, array_keys((array) $data[0]));
                
                // Write data
                foreach ($data as $row) {
                    fputcsv($file, (array) $row);
                }
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

