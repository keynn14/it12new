<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportsController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index()
    {
        return view('reports.index');
    }

    public function inventoryMovement(Request $request)
    {
        $filters = $request->only(['item_id', 'movement_type', 'date_from', 'date_to']);
        $data = $this->reportService->getInventoryMovementReport($filters);

        if ($request->has('export')) {
            return $this->exportReport($data, 'inventory_movement', $request->export);
        }

        return view('reports.inventory_movement', compact('data', 'filters'));
    }

    public function purchaseHistory(Request $request)
    {
        $filters = $request->only(['supplier_id', 'status', 'date_from', 'date_to']);
        $data = $this->reportService->getPurchaseHistoryReport($filters);

        if ($request->has('export')) {
            return $this->exportReport($data, 'purchase_history', $request->export);
        }

        return view('reports.purchase_history', compact('data', 'filters'));
    }

    public function projectConsumption(Request $request)
    {
        $request->validate(['project_id' => 'required|exists:projects,id']);
        
        $filters = $request->only(['project_id', 'date_from', 'date_to']);
        $data = $this->reportService->getProjectConsumptionReport($request->project_id, $filters);

        if ($request->has('export')) {
            return $this->exportReport($data, 'project_consumption', $request->export);
        }

        return view('reports.project_consumption', compact('data', 'filters'));
    }

    public function supplierPerformance(Request $request)
    {
        $filters = $request->only(['date_from', 'date_to']);
        $data = $this->reportService->getSupplierPerformanceReport($filters);

        if ($request->has('export')) {
            return $this->exportReport($data, 'supplier_performance', $request->export);
        }

        return view('reports.supplier_performance', compact('data', 'filters'));
    }

    public function delayedProjects(Request $request)
    {
        $data = $this->reportService->getDelayedProjectsReport();

        if ($request->has('export')) {
            return $this->exportReport($data, 'delayed_projects', $request->export);
        }

        return view('reports.delayed_projects', compact('data'));
    }

    protected function exportReport($data, $reportName, $format)
    {
        switch ($format) {
            case 'pdf':
                $pdf = Pdf::loadView("reports.pdf.{$reportName}", compact('data'));
                return $pdf->download("{$reportName}_" . date('Y-m-d') . ".pdf");

            case 'csv':
                return $this->reportService->exportToCsv($data->toArray(), "{$reportName}_" . date('Y-m-d') . ".csv");

            case 'json':
                return response()->json($data);

            default:
                return redirect()->back()->with('error', 'Invalid export format.');
        }
    }
}

