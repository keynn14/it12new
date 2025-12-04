<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\InventoryItem;
use App\Models\MaterialIssuance;
use App\Models\GoodsReceipt;
use App\Models\GoodsReturn;
use App\Services\StockService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function index()
    {
        $user = auth()->user();
        
        if (!$user || !$user->role) {
            return redirect()->route('login');
        }

        $roleSlug = $user->role->slug;

        // Route to role-specific dashboard method
        switch ($roleSlug) {
            case 'admin':
                return $this->adminDashboard();
            case 'inventory_manager':
                return $this->inventoryManagerDashboard();
            case 'purchasing':
                return $this->purchasingDashboard();
            case 'project_manager':
                return $this->projectManagerDashboard();
            case 'warehouse_manager':
                return $this->warehouseManagerDashboard();
            default:
                // Fallback to admin dashboard for unknown roles
                return $this->adminDashboard();
        }
    }

    /**
     * Admin Dashboard - Full access to all data
     */
    protected function adminDashboard()
    {
        $totalProjects = Project::where('status', '!=', 'completed')->count();
        $activeProjects = Project::where('status', 'active')->count();
        $pendingPOs = PurchaseOrder::where('status', 'pending')->count();
        $lowStockItems = InventoryItem::get()->filter(function ($item) {
            return $this->stockService->checkReorderLevel($item->id);
        })->count();

        $recentProjects = Project::latest()->take(5)->get();
        $recentPOs = PurchaseOrder::with('supplier')->latest()->take(5)->get();
        $recentMaterialIssuances = MaterialIssuance::with('project')->latest()->take(5)->get();

        $projectStatusData = Project::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $poStatusData = PurchaseOrder::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $monthlyPOs = PurchaseOrder::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as count')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $monthlyProjects = Project::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as count')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $inventoryMovements = $this->getInventoryMovements();
        $topSuppliers = $this->getTopSuppliers();

        return view('dashboards.admin', compact(
            'totalProjects',
            'activeProjects',
            'pendingPOs',
            'lowStockItems',
            'recentProjects',
            'recentPOs',
            'recentMaterialIssuances',
            'projectStatusData',
            'poStatusData',
            'monthlyPOs',
            'monthlyProjects',
            'inventoryMovements',
            'topSuppliers'
        ));
    }

    /**
     * Inventory Manager Dashboard - Focus on inventory operations
     */
    protected function inventoryManagerDashboard()
    {
        $totalItems = InventoryItem::count();
        $lowStockItems = InventoryItem::get()->filter(function ($item) {
            return $this->stockService->checkReorderLevel($item->id);
        })->count();
        
        $pendingReceipts = GoodsReceipt::where('status', 'pending')->count();
        $pendingReturns = GoodsReturn::where('status', 'pending')->count();
        
        $recentReceipts = GoodsReceipt::with('purchaseOrder.supplier')->latest()->take(5)->get();
        $recentReturns = GoodsReturn::with('goodsReceipt.purchaseOrder.supplier')->latest()->take(5)->get();
        $recentIssuances = MaterialIssuance::with('project')->latest()->take(5)->get();

        $inventoryMovements = $this->getInventoryMovements();
        
        $receiptStatusData = GoodsReceipt::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $monthlyReceipts = GoodsReceipt::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as count')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $monthlyIssuances = MaterialIssuance::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as count')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        return view('dashboards.inventory_manager', compact(
            'totalItems',
            'lowStockItems',
            'pendingReceipts',
            'pendingReturns',
            'recentReceipts',
            'recentReturns',
            'recentIssuances',
            'inventoryMovements',
            'receiptStatusData',
            'monthlyReceipts',
            'monthlyIssuances'
        ));
    }

    /**
     * Purchasing Dashboard - Focus on procurement
     */
    protected function purchasingDashboard()
    {
        $pendingPOs = PurchaseOrder::where('status', 'pending')->count();
        $pendingPRs = PurchaseRequest::where('status', 'pending')->count();
        $totalSuppliers = \App\Models\Supplier::count();
        $activeQuotations = \App\Models\Quotation::where('status', 'pending')->count();

        $recentPOs = PurchaseOrder::with('supplier')->latest()->take(5)->get();
        $recentPRs = PurchaseRequest::with('project')->latest()->take(5)->get();
        $recentQuotations = \App\Models\Quotation::with('supplier')->latest()->take(5)->get();

        $poStatusData = PurchaseOrder::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $prStatusData = PurchaseRequest::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $monthlyPOs = PurchaseOrder::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as count')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $topSuppliers = $this->getTopSuppliers();

        return view('dashboards.purchasing', compact(
            'pendingPOs',
            'pendingPRs',
            'totalSuppliers',
            'activeQuotations',
            'recentPOs',
            'recentPRs',
            'recentQuotations',
            'poStatusData',
            'prStatusData',
            'monthlyPOs',
            'topSuppliers'
        ));
    }

    /**
     * Project Manager Dashboard - Focus on projects
     */
    protected function projectManagerDashboard()
    {
        $user = auth()->user();
        
        $myProjects = Project::where('project_manager_id', $user->id)
            ->where('status', '!=', 'completed')->count();
        $activeProjects = Project::where('project_manager_id', $user->id)
            ->where('status', 'active')->count();
        $pendingChangeOrders = \App\Models\ChangeOrder::whereHas('project', function($q) use ($user) {
            $q->where('project_manager_id', $user->id);
        })->where('status', 'pending')->count();
        $pendingPRs = PurchaseRequest::whereHas('project', function($q) use ($user) {
            $q->where('project_manager_id', $user->id);
        })->where('status', 'pending')->count();

        $recentProjects = Project::where('project_manager_id', $user->id)->latest()->take(5)->get();
        $recentChangeOrders = \App\Models\ChangeOrder::whereHas('project', function($q) use ($user) {
            $q->where('project_manager_id', $user->id);
        })->with('project')->latest()->take(5)->get();
        $recentPRs = PurchaseRequest::whereHas('project', function($q) use ($user) {
            $q->where('project_manager_id', $user->id);
        })->with('project')->latest()->take(5)->get();

        $projectStatusData = Project::where('project_manager_id', $user->id)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $monthlyProjects = Project::where('project_manager_id', $user->id)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as count')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        return view('dashboards.project_manager', compact(
            'myProjects',
            'activeProjects',
            'pendingChangeOrders',
            'pendingPRs',
            'recentProjects',
            'recentChangeOrders',
            'recentPRs',
            'projectStatusData',
            'monthlyProjects'
        ));
    }

    /**
     * Warehouse Manager Dashboard - Focus on warehouse operations and quality inspection
     */
    protected function warehouseManagerDashboard()
    {
        $pendingInspections = GoodsReceipt::where('status', 'pending')->count();
        $pendingReturns = GoodsReturn::where('status', 'pending')->count();
        $approvedToday = GoodsReceipt::whereDate('approved_at', today())->count();
        $rejectedToday = GoodsReceipt::whereDate('rejected_at', today())->count();

        $recentReceipts = GoodsReceipt::with('purchaseOrder.supplier')->latest()->take(5)->get();
        $recentReturns = GoodsReturn::with('goodsReceipt.purchaseOrder.supplier')->latest()->take(5)->get();

        $receiptStatusData = GoodsReceipt::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $monthlyApprovals = GoodsReceipt::selectRaw('DATE_FORMAT(approved_at, "%Y-%m") as month, count(*) as count')
            ->whereNotNull('approved_at')
            ->where('approved_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $inventoryMovements = $this->getInventoryMovements();

        return view('dashboards.warehouse_manager', compact(
            'pendingInspections',
            'pendingReturns',
            'approvedToday',
            'rejectedToday',
            'recentReceipts',
            'recentReturns',
            'receiptStatusData',
            'monthlyApprovals',
            'inventoryMovements'
        ));
    }

    /**
     * Helper method to get inventory movements
     */
    protected function getInventoryMovements()
    {
        $inventoryMovementsRaw = \App\Models\StockMovement::selectRaw('DATE(created_at) as date, movement_type, SUM(quantity) as total')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date', 'movement_type')
            ->orderBy('date')
            ->get();
        
        $inventoryMovements = [];
        foreach ($inventoryMovementsRaw as $movement) {
            $date = $movement->date;
            if (!isset($inventoryMovements[$date])) {
                $inventoryMovements[$date] = [];
            }
            $inventoryMovements[$date][] = [
                'movement_type' => $movement->movement_type,
                'total' => $movement->total
            ];
        }

        return $inventoryMovements;
    }

    /**
     * Helper method to get top suppliers
     */
    protected function getTopSuppliers()
    {
        return PurchaseOrder::selectRaw('supplier_id, count(*) as order_count, SUM(total_amount) as total_amount')
            ->whereNotNull('supplier_id')
            ->groupBy('supplier_id')
            ->with('supplier')
            ->orderByDesc('order_count')
            ->take(5)
            ->get();
    }
}

