<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;600;700&family=Noto+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Noto Sans', 'Noto Sans Bengali', 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 30px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #3b82f6;
        }
        .company-info h1 {
            font-size: 24px;
            color: #3b82f6;
            margin-bottom: 5px;
        }
        .company-info p {
            color: #666;
            font-size: 11px;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 5px;
        }
        .invoice-title p {
            color: #666;
            font-size: 11px;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .billing-info, .order-info {
            width: 48%;
        }
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #3b82f6;
            text-transform: uppercase;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row {
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            color: #666;
        }
        .info-value {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #f3f4f6;
            padding: 10px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .totals-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }
        .totals-table {
            width: 300px;
        }
        .totals-table td {
            border: none;
            padding: 8px 10px;
        }
        .totals-table .total-row {
            background-color: #3b82f6;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }
        .totals-table .total-row td {
            color: white;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 10px;
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
        .thank-you {
            text-align: center;
            margin-top: 30px;
            padding: 15px;
            background-color: #f9fafb;
            border-radius: 8px;
        }
        .thank-you h3 {
            color: #3b82f6;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .thank-you p {
            color: #666;
            font-size: 10px;
        }
        .product-name {
            font-family: 'Noto Sans', 'Noto Sans Bengali', 'Helvetica', 'Arial', sans-serif;
            font-size: 13px;
            line-height: 1.6;
            max-width: 350px;
            word-wrap: break-word;
            white-space: pre-wrap;
        }
        @media print {
            body {
                padding: 0;
            }
            .invoice-container {
                border: none;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <h1>Carttelo</h1>
                <p>Your Trusted Online Store</p>
                <p>Email: support@carttelo.com | Phone: +880 1XXX-XXXXXX</p>
            </div>
            <div class="invoice-title">
                <h2>INVOICE</h2>
                <p>Invoice #: INV-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p>Date: {{ $order->created_at->format('M d, Y') }}</p>
                <p>Order ID: #{{ $order->id }}</p>
            </div>
        </div>

        <!-- Customer & Order Info -->
        <div class="invoice-details">
            <div class="billing-info">
                <div class="section-title">Bill To</div>
                <div class="info-row">
                    <span class="info-value" style="font-size: 14px; font-weight: bold;">{{ $order->customer_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-value">{{ $order->customer_phone }}</span>
                </div>
                @if($order->customer_email)
                <div class="info-row">
                    <span class="info-value">{{ $order->customer_email }}</span>
                </div>
                @endif
                <div class="info-row" style="margin-top: 10px;">
                    <span class="info-label">Delivery Address:</span><br>
                    <span class="info-value">{{ $order->customer_address }}</span>
                </div>
            </div>
            <div class="order-info">
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
        </div>

        <!-- Order Items -->
        <table>
            <thead>
                <tr>
                    <th style="width: 55%;">Product</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="product-name">{{ $order->product->name }}</div>
                        <span style="font-size: 10px; color: #666;">Product ID: {{ $order->product->id }}</span>
                    </td>
                    <td class="text-center">{{ $order->quantity }}</td>
                    <td class="text-right">৳{{ number_format($order->product->finalPrice, 2) }}</td>
                    <td class="text-right">৳{{ number_format($order->product->finalPrice * $order->quantity, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td class="info-label">Subtotal:</td>
                    <td class="text-right">৳{{ number_format($order->total_amount - $order->delivery_charge, 2) }}</td>
                </tr>
                <tr>
                    <td class="info-label">Delivery Charge:</td>
                    <td class="text-right">৳{{ number_format($order->delivery_charge, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total Amount:</td>
                    <td class="text-right">৳{{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <!-- Thank You -->
        <div class="thank-you">
            <h3>Thank You for Your Order!</h3>
            <p>If you have any questions about this invoice, please contact our customer support.</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This is a computer-generated invoice and does not require a signature.</p>
            <p style="margin-top: 5px;">Carttelo - {{ date('Y') }}</p>
        </div>
    </div>

    <!-- Print Button (hidden when printing) -->
    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 30px; background: #3b82f6; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px;">
            Print Invoice
        </button>
        <button onclick="window.close()" style="padding: 10px 30px; background: #6b7280; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; margin-left: 10px;">
            Close
        </button>
    </div>
</body>
</html>
