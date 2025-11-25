<!DOCTYPE html>
<html>
<head>
    <title>Purchase Order: {{ $purchaseOrder->po_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PURCHASE ORDER</h1>
        <p>PO Number: {{ $purchaseOrder->po_number }}</p>
        <p>Date: {{ $purchaseOrder->po_date->format('Y-m-d') }}</p>
    </div>
    
    <div>
        <p><strong>Supplier:</strong> {{ $purchaseOrder->supplier->name }}</p>
        <p><strong>Address:</strong> {{ $purchaseOrder->supplier->address ?? 'N/A' }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchaseOrder->items as $item)
                <tr>
                    <td>{{ $item->inventoryItem->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->unit_price, 2) }}</td>
                    <td>${{ number_format($item->total_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total:</th>
                <th>${{ number_format($purchaseOrder->total_amount, 2) }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>

