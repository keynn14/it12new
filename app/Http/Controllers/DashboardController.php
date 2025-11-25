<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\PurchaseOrder;
use App\Models\InventoryItem;
use App\Models\FabricationJob;
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
        // Stats
        $totalProjects = Project::count();
        $activeProjects = Project::where('status', 'active')->count();
        $totalPurchaseOrders = PurchaseOrder::count();
        $pendingPOs = PurchaseOrder::where('status', 'pending')->count();
        
        // Inventory stats
        $totalItems = InventoryItem::count();
        $lowStockItems = InventoryItem::get()->filter(function ($item) {
            return $this->stockService->checkReorderLevel($item->id);
        })->count();

        // Recent activities
        $recentProjects = Project::latest()->take(5)->get();
        $recentPOs = PurchaseOrder::with('supplier')->latest()->take(5)->get();
        $recentFabricationJobs = FabricationJob::with('project')->latest()->take(5)->get();

        // Chart data
        $projectStatusData = Project::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $poStatusData = PurchaseOrder::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('dashboard', compact(
            'totalProjects',
            'activeProjects',
            'totalPurchaseOrders',
            'pendingPOs',
            'totalItems',
            'lowStockItems',
            'recentProjects',
            'recentPOs',
            'recentFabricationJobs',
            'projectStatusData',
            'poStatusData'
        ));
    }
}

