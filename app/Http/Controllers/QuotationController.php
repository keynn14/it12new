<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\PurchaseRequest;
use App\Models\Supplier;
use App\Services\ProcurementService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuotationController extends Controller
{
    protected $procurementService;

    public function __construct(ProcurementService $procurementService)
    {
        $this->procurementService = $procurementService;
    }

    public function index(Request $request)
    {
        $query = Quotation::with(['purchaseRequest', 'supplier']);

        if ($request->has('purchase_request_id')) {
            $query->where('purchase_request_id', $request->purchase_request_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $quotations = $query->latest()->paginate(15);

        return view('quotations.index', compact('quotations'));
    }

    public function create(Request $request)
    {
        $purchaseRequest = null;
        if ($request->has('purchase_request_id')) {
            $purchaseRequest = PurchaseRequest::with('items.inventoryItem')->findOrFail($request->purchase_request_id);
        }
        $suppliers = Supplier::where('status', 'active')->get();
        return view('quotations.create', compact('purchaseRequest', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_request_id' => 'required|exists:purchase_requests,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quotation_date' => 'required|date',
            'valid_until' => 'required|date|after:quotation_date',
            'terms_conditions' => 'nullable|string',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.inventory_item_id' => 'required|exists:inventory_items,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.specifications' => 'nullable|string',
        ]);

        $validated['quotation_number'] = 'QT-' . strtoupper(Str::random(8));
        $validated['status'] = 'pending';

        $quotation = $this->procurementService->createQuotation($validated);

        return redirect()->route('quotations.show', $quotation)->with('success', 'Quotation created successfully.');
    }

    public function show(Quotation $quotation)
    {
        $quotation->load(['purchaseRequest', 'supplier', 'items.inventoryItem']);
        return view('quotations.show', compact('quotation'));
    }

    public function compare(Request $request)
    {
        $purchaseRequestId = $request->purchase_request_id;
        $quotations = Quotation::with(['supplier', 'items.inventoryItem'])
            ->where('purchase_request_id', $purchaseRequestId)
            ->where('status', 'pending')
            ->get();

        return view('quotations.compare', compact('quotations', 'purchaseRequestId'));
    }
}

