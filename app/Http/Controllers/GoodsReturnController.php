<?php

namespace App\Http\Controllers;

use App\Models\GoodsReturn;
use App\Models\GoodsReceipt;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GoodsReturnController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function index(Request $request)
    {
        $query = GoodsReturn::with(['goodsReceipt.purchaseOrder', 'returnedBy', 'approvedBy']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $goodsReturns = $query->latest()->paginate(15);

        return view('goods_returns.index', compact('goodsReturns'));
    }

    public function create(Request $request)
    {
        $goodsReceipt = null;
        if ($request->has('goods_receipt_id')) {
            $goodsReceipt = GoodsReceipt::with(['items.inventoryItem', 'purchaseOrder'])->findOrFail($request->goods_receipt_id);
        }
        return view('goods_returns.create', compact('goodsReceipt'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'goods_receipt_id' => 'required|exists:goods_receipts,id',
            'return_date' => 'required|date',
            'reason' => 'required|string',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.goods_receipt_item_id' => 'required|exists:goods_receipt_items,id',
            'items.*.inventory_item_id' => 'required|exists:inventory_items,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.reason' => 'nullable|string',
        ]);

        $validated['return_number'] = 'RT-' . strtoupper(Str::random(8));
        $validated['status'] = 'draft';
        $validated['returned_by'] = auth()->id();

        $return = GoodsReturn::create($validated);

        foreach ($validated['items'] as $item) {
            $return->items()->create($item);
        }

        return redirect()->route('goods-returns.show', $return)->with('success', 'Goods return created successfully.');
    }

    public function show(GoodsReturn $goodsReturn)
    {
        $goodsReturn->load(['goodsReceipt.purchaseOrder', 'items.inventoryItem', 'returnedBy', 'approvedBy']);
        return view('goods_returns.show', compact('goodsReturn'));
    }

    public function approve(Request $request, GoodsReturn $goodsReturn)
    {
        $goodsReturn->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        foreach ($goodsReturn->items as $item) {
            $this->stockService->processGoodsReturn($item->inventory_item_id, $item->quantity, $goodsReturn->id);
        }

        return redirect()->route('goods-returns.show', $goodsReturn)->with('success', 'Goods return approved and stock updated.');
    }
}

