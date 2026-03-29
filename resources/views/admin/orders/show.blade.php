@extends('layouts.admin')

@section('title', 'Order Details')
@section('page_title', 'Order #' . $order->id)

@section('content')
    <style>
        .card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #e5e7eb;
            margin-bottom: 24px;
        }
        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f3f4f6;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-size: 14px;
            color: #6b7280;
        }
        .info-value {
            font-size: 14px;
            font-weight: 500;
            color: #1f2937;
        }
        
        /* Status Cards */
        .status-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }
        @media (max-width: 640px) {
            .status-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }
        }
        .status-card {
            padding: 12px 8px;
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: white;
            min-width: 0;
            overflow: hidden;
        }
        .status-card:hover {
            border-color: #3b82f6;
            background: #f8fafc;
        }
        .status-card.active {
            border-color: #3b82f6;
            background: #eff6ff;
        }
        .status-card.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .status-icon {
            font-size: 20px;
            margin-bottom: 6px;
        }
        .status-label {
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            white-space: nowrap;
        }
        
        /* Product Card */
        .product-card {
            display: flex;
            gap: 16px;
            padding: 16px;
            background: #f9fafb;
            border-radius: 12px;
        }
        .product-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
        }
        .product-info {
            flex: 1;
        }
        .product-name {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
        }
        .product-price {
            font-size: 18px;
            font-weight: 700;
            color: #3b82f6;
        }
        
        /* Total Box */
        .total-box {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
        }
        .total-label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 4px;
        }
        .total-amount {
            font-size: 32px;
            font-weight: 800;
        }
        
        /* Back Button */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            color: #374151;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-back:hover {
            background: #f9fafb;
        }
    </style>

    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="btn-back">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Orders
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="xl:col-span-2">
            <!-- Status Management -->
            <div class="card">
                <h3 class="card-title">Update Order Status</h3>
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" id="statusForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" id="statusInput" value="{{ $order->status }}">
                    
                    <div class="status-grid">
                        @foreach ($statuses as $key => $status)
                            <div class="status-card {{ $order->status === $key ? 'active' : '' }}" 
                                 onclick="updateStatus('{{ $key }}')">
                                <div class="status-icon">{{ $status['icon'] }}</div>
                                <div class="status-label">{{ $status['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>

            <!-- Product Details -->
            <div class="card">
                <h3 class="card-title">Product Information</h3>
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Product -->
                    <div class="product-card flex-1">
                        @if ($order->product->primaryImage)
                            <img src="{{ asset('storage/' . $order->product->primaryImage) }}" alt="{{ $order->product->name }}" class="product-image">
                        @else
                            <div class="product-image bg-gray-200 flex items-center justify-center text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div class="product-info">
                            <div class="product-name">{{ $order->product->name }}</div>
                            <div class="text-sm text-gray-500 mb-2">Quantity: {{ $order->quantity }} x ৳{{ number_format($order->product->finalPrice, 2) }}</div>
                            <div class="product-price">৳{{ number_format($order->product->finalPrice * $order->quantity, 2) }}</div>
                        </div>
                    </div>
                    
                    <!-- Order Total Breakdown -->
                    <div class="flex-1 bg-gray-50 rounded-xl p-4">
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">৳{{ number_format($order->total_amount - $order->delivery_charge, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Delivery Charge</span>
                                <span class="font-medium">৳{{ number_format($order->delivery_charge, 2) }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3 mt-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-800 font-semibold">Total Amount</span>
                                    <span class="text-xl font-bold text-blue-600">৳{{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Details -->
            <div class="card">
                <h3 class="card-title">Customer Information</h3>
                <div class="info-row">
                    <span class="info-label">Full Name</span>
                    <span class="info-value">{{ $order->customer_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phone Number</span>
                    <span class="info-value">{{ $order->customer_phone }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $order->customer_email ?? 'Not provided' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Delivery Address</span>
                    <span class="info-value" style="max-width: 300px; text-align: right;">{{ $order->customer_address }}</span>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div>
            <!-- Order Summary -->
            <div class="card">
                <h3 class="card-title">Order Summary</h3>
                <div class="info-row">
                    <span class="info-label">Order ID</span>
                    <span class="info-value">#{{ $order->id }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Order Date</span>
                    <span class="info-value">{{ $order->created_at->format('M d, Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Current Status</span>
                    <span class="info-value">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-{{ $statuses[$order->status]['color'] }}-100 text-{{ $statuses[$order->status]['color'] }}-800">
                            {{ $statuses[$order->status]['icon'] }} {{ $statuses[$order->status]['label'] }}
                        </span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Delivery Location</span>
                    <span class="info-value">{{ $order->delivery_location === 'inside_dhaka' ? 'Inside Dhaka' : 'Outside Dhaka' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Subtotal</span>
                    <span class="info-value">৳{{ number_format($order->total_amount - $order->delivery_charge, 2) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Delivery Charge</span>
                    <span class="info-value">৳{{ number_format($order->delivery_charge, 2) }}</span>
                </div>
            </div>

            <!-- Total -->
            <div class="total-box">
                <div class="total-label">Total Amount</div>
                <div class="total-amount">৳{{ number_format($order->total_amount, 2) }}</div>
            </div>
        </div>
    </div>

    <script>
        function updateStatus(status) {
            document.getElementById('statusInput').value = status;
            document.getElementById('statusForm').submit();
        }
    </script>
@endsection
