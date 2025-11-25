<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\StockMovement;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InventoryController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function index(Request $request)
    {
        $query = InventoryItem::withCount('stockMovements');

        if ($request->has('item_type')) {
            $query->where('item_type', $request->item_type);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('item_code', 'like', "%{$search}%");
            });
        }

        $items = $query->latest()->paginate(15);

        // Add current stock to each item
        $items->getCollection()->transform(function ($item) {
            $item->current_stock = $this->stockService->getCurrentStock($item->id);
            $item->needs_reorder = $this->stockService->checkReorderLevel($item->id);
            return $item;
        });

        return view('inventory.index', compact('items'));
    }

    public function create()
    {
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'unit_of_measure' => 'required|string',
            'unit_cost' => 'required|numeric|min:0',
            'reorder_level' => 'nullable|numeric|min:0',
            'reorder_quantity' => 'nullable|numeric|min:0',
            'item_type' => 'required|in:raw_material,finished_good,consumable,tool',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['item_code'] = 'ITM-' . strtoupper(Str::random(8));

        $item = InventoryItem::create($validated);

        return redirect()->route('inventory.show', $item)->with('success', 'Inventory item created successfully.');
    }

    public function show(InventoryItem $inventoryItem)
    {
        $currentStock = $this->stockService->getCurrentStock($inventoryItem->id);
        $movements = StockMovement::where('inventory_item_id', $inventoryItem->id)
            ->with('createdBy')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('inventory.show', compact('inventoryItem', 'currentStock', 'movements'));
    }

    public function edit(InventoryItem $inventoryItem)
    {
        return view('inventory.edit', compact('inventoryItem'));
    }

    public function update(Request $request, InventoryItem $inventoryItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'unit_of_measure' => 'required|string',
            'unit_cost' => 'required|numeric|min:0',
            'reorder_level' => 'nullable|numeric|min:0',
            'reorder_quantity' => 'nullable|numeric|min:0',
            'item_type' => 'required|in:raw_material,finished_good,consumable,tool',
            'status' => 'required|in:active,inactive',
        ]);

        $inventoryItem->update($validated);

        return redirect()->route('inventory.show', $inventoryItem)->with('success', 'Inventory item updated successfully.');
    }

    public function adjustStock(Request $request, InventoryItem $inventoryItem)
    {
        $validated = $request->validate([
            'quantity' => 'required|numeric',
            'type' => 'required|in:adjustment_in,adjustment_out',
            'notes' => 'nullable|string',
        ]);

        $this->stockService->adjustStock($inventoryItem->id, $validated['quantity'], $validated['type'], $validated['notes'] ?? null);

        return redirect()->route('inventory.show', $inventoryItem)->with('success', 'Stock adjusted successfully.');
    }
}

