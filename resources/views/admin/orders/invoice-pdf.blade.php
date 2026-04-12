<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #{{ $order->id }}</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
            width: 100%;
            max-width: 190mm;
        }
        .invoice-container {
            width: 100%;
            padding: 5mm;
        }
        
        /* Header */
        .header {
            width: 100%;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3b82f6;
            overflow: hidden;
        }
        .header-left {
            float: left;
            width: 50%;
        }
        .header-right {
            float: right;
            width: 50%;
            text-align: right;
        }
        .company-info h1 {
            font-size: 20px;
            color: #3b82f6;
            margin-bottom: 3px;
        }
        .company-info p {
            color: #666;
            font-size: 8px;
            line-height: 1.5;
        }
        .invoice-title h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 3px;
        }
        .invoice-title p {
            color: #666;
            font-size: 8px;
            line-height: 1.5;
        }
        .clear {
            clear: both;
        }
        
        /* Two Column Layout */
        .two-column {
            width: 100%;
            margin-bottom: 15px;
            overflow: hidden;
        }
        .column {
            float: left;
            width: 48%;
        }
        .column-right {
            float: right;
            width: 48%;
        }
        .section-title {
            font-size: 9px;
            font-weight: bold;
            color: #3b82f6;
            text-transform: uppercase;
            margin-bottom: 6px;
            padding-bottom: 3px;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row {
            margin-bottom: 4px;
            font-size: 9px;
        }
        .info-label {
            font-weight: bold;
            color: #666;
        }
        .info-value {
            color: #333;
        }
        
        /* Product Table */
        table.product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            table-layout: fixed;
        }
        table.product-table th {
            background-color: #f3f4f6;
            padding: 8px 6px;
            text-align: left;
            font-size: 8px;
            font-weight: bold;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }
        table.product-table td {
            padding: 8px 6px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
            font-size: 9px;
            word-wrap: break-word;
        }
        table.product-table th:nth-child(1) { width: 45%; }
        table.product-table th:nth-child(2) { width: 15%; text-align: center; }
        table.product-table th:nth-child(3) { width: 20%; text-align: right; }
        table.product-table th:nth-child(4) { width: 20%; text-align: right; }
        table.product-table td:nth-child(2) { text-align: center; }
        table.product-table td:nth-child(3) { text-align: right; }
        table.product-table td:nth-child(4) { text-align: right; }
        
        /* Totals Table */
        .totals-wrapper {
            width: 100%;
            overflow: hidden;
        }
        table.totals-table {
            width: 220px;
            float: right;
            border-collapse: collapse;
        }
        table.totals-table td {
            border: none;
            padding: 5px 8px;
            font-size: 9px;
        }
        table.totals-table td:first-child {
            text-align: left;
        }
        table.totals-table td:last-child {
            text-align: right;
        }
        table.totals-table .total-row {
            background-color: #3b82f6;
            color: white;
            font-weight: bold;
            font-size: 11px;
        }
        table.totals-table .total-row td {
            color: white;
            padding: 8px;
        }
        
        /* Footer */
        .footer {
            margin-top: 25px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #666;
            font-size: 7px;
            clear: both;
        }
        
        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-processing {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .status-delivered {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        /* Thank You */
        .thank-you {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: #f9fafb;
            border-radius: 6px;
            clear: both;
        }
        .thank-you h3 {
            color: #3b82f6;
            font-size: 11px;
            margin-bottom: 3px;
        }
        .thank-you p {
            color: #666;
            font-size: 8px;
        }
        
        /* Product Name */
        .product-name {
            font-size: 9px;
            line-height: 1.3;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <div class="company-info">
                    <h1>Carttelo</h1>
                    <p>Your Trusted Online Store</p>
                    <p>Email: support@carttelo.com | Phone: +880 1XXX-XXXXXX</p>
                </div>
            </div>
            <div class="header-right">
                <div class="invoice-title">
                    <h2>INVOICE</h2>
                    <p>Invoice #: INV-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p>Date: {{ $order->created_at->format('M d, Y') }}</p>
                    <p>Order ID: #{{ $order->id }}</p>
                </div>
            </div>
            <div class="clear"></div>
        </div>

        <!-- Customer & Order Info -->
        <div class="two-column">
            <div class="column">
                <div class="section-title">Bill To</div>
                <div class="info-row">
                    <span class="info-value" style="font-size: 11px; font-weight: bold;">{{ $order->customer_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-value">{{ $order->customer_phone }}</span>
                </div>
                @if($order->customer_email)
                <div class="info-row">
                    <span class="info-value">{{ $order->customer_email }}</span>
                </div>
                @endif
                <div class="info-row" style="margin-top: 5px;">
                    <span class="info-label">Delivery Address:</span><br>
                    <span class="info-value">{{ $order->customer_address }}</span>
                </div>
            </div>
            <div class="column-right">
                <div class="section-title">Order Details</div>
                <div class="info-row">
                    <span class="info-label">Order Date:</span>
                    <span class="info-value">{{ $order->created_at->format('M d, Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Delivery Location:</span>
                    <span class="info-value">{{ $order->delivery_location === 'inside_dhaka' ? 'Inside Dhaka' : 'Outside Dhaka' }}</span>
                </div>
            </div>
            <div class="clear"></div>
        </div>

        <!-- Order Items -->
        <table class="product-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="product-name">{{ $order->product->name }}</div>
                        <span style="font-size: 7px; color: #666;">Product ID: {{ $order->product->id }}</span>
                    </td>
                    <td>{{ $order->quantity }}</td>
                    <td>Tk {{ number_format($order->product->finalPrice, 2) }}</td>
                    <td>Tk {{ number_format($order->product->finalPrice * $order->quantity, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals-wrapper">
            <table class="totals-table">
                <tr>
                    <td class="info-label">Subtotal:</td>
                    <td>Tk {{ number_format($order->total_amount - $order->delivery_charge, 2) }}</td>
                </tr>
                <tr>
                    <td class="info-label">Delivery Charge:</td>
                    <td>Tk {{ number_format($order->delivery_charge, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total Amount:</td>
                    <td>Tk {{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </table>
            <div class="clear"></div>
        </div>

        <!-- Thank You -->
        <div class="thank-you">
            <h3>Thank You for Your Order!</h3>
            <p>If you have any questions about this invoice, please contact our customer support.</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This is a computer-generated invoice and does not require a signature.</p>
            <p style="margin-top: 2px;">Carttelo - {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>
