@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
    <style>
        .order-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .order-card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .order-header {
            text-align: center;
            margin-bottom: 32px;
            padding-bottom: 24px;
            border-bottom: 2px solid #f3f4f6;
        }
        .order-id {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }
        .order-date {
            color: #6b7280;
            font-size: 14px;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: 600;
            margin-top: 16px;
        }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-processing { background: #dbeafe; color: #1e40af; }
        .status-delivered { background: #dcfce7; color: #166534; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        
        /* Progress Bar */
        .progress-section {
            margin: 32px 0;
            padding: 24px;
            background: #f9fafb;
            border-radius: 12px;
        }
        .progress-title {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 20px;
            text-align: center;
        }
        .progress-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-bottom: 8px;
        }
        .progress-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 4px;
            background: #e5e7eb;
            z-index: 0;
        }
        .progress-line {
            position: absolute;
            top: 20px;
            left: 0;
            height: 4px;
            background: #3b82f6;
            z-index: 1;
            transition: width 0.5s ease;
        }
        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            flex: 1;
        }
        .step-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            background: white;
            border: 3px solid #e5e7eb;
            transition: all 0.3s ease;
        }
        .progress-step.active .step-icon {
            border-color: #3b82f6;
            background: #eff6ff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
        }
        .progress-step.completed .step-icon {
            border-color: #3b82f6;
            background: #3b82f6;
        }
        .step-label {
            font-size: 12px;
            font-weight: 600;
            color: #9ca3af;
            margin-top: 8px;
            text-align: center;
        }
        .progress-step.active .step-label {
            color: #3b82f6;
        }
        .progress-step.completed .step-label {
            color: #3b82f6;
        }
        
        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin: 24px 0;
        }
        .info-item {
            padding: 16px;
            background: #f9fafb;
            border-radius: 10px;
        }
        .info-label {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .info-value {
            font-size: 15px;
            font-weight: 600;
            color: #1f2937;
        }
        
        /* Product Section */
        .product-section {
            display: flex;
            gap: 20px;
            padding: 20px;
            background: #f9fafb;
            border-radius: 12px;
            margin: 24px 0;
        }
        .product-image {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            object-fit: cover;
        }
        .product-info {
            flex: 1;
        }
        .product-name {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }
        .product-meta {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 4px;
        }
        .product-price {
            font-size: 20px;
            font-weight: 700;
            color: #3b82f6;
        }
        
        /* Total Section */
        .total-section {
            margin-top: 24px;
            padding-top: 24px;
            border-top: 2px solid #f3f4f6;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }
        .total-label {
            color: #6b7280;
        }
        .total-value {
            font-weight: 600;
            color: #1f2937;
        }
        .total-final {
            display: flex;
            justify-content: space-between;
            padding: 16px 0;
            margin-top: 8px;
            border-top: 2px solid #e5e7eb;
        }
        .total-final-label {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
        }
        .total-final-value {
            font-size: 24px;
            font-weight: 800;
            color: #3b82f6;
        }
        
        /* Back Button */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: #f3f4f6;
            color: #374151;
            font-weight: 600;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s;
            margin-top: 24px;
        }
        .btn-back:hover {
            background: #e5e7eb;
        }
        
        .cancelled-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 24px;
            border-radius: 12px;
            text-align: center;
            margin: 24px 0;
        }
        .cancelled-message .icon {
            font-size: 48px;
            margin-bottom: 12px;
        }
        .cancelled-message h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
        }
    </style>

    <div class="order-container">
        <div class="order-card">
            <!-- Header -->
            <div class="order-header">
                <div class="order-id">Order #{{ $order->id }}</div>
                <div class="order-date">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</div>
                <div class="status-badge status-{{ $order->status }}">
                    {{ $statusSteps[$order->status]['icon'] }} {{ $statusSteps[$order->status]['label'] }}
                </div>
            </div>

            @if($order->status !== 'cancelled')
                @php
                    $currentStep = ['pending' => 1, 'processing' => 2, 'delivered' => 3][$order->status] ?? 1;
                    $progressWidth = (($currentStep - 1) / 2) * 100;
                @endphp
                
                <!-- Progress Bar -->
                <div class="progress-section">
                    <div class="progress-title">Order Progress</div>
                    <div class="progress-steps">
                        <div class="progress-line" style="width: {{ $progressWidth }}%;"></div>
                        
                        <div class="progress-step {{ $currentStep >= 1 ? 'completed' : '' }} {{ $currentStep == 1 ? 'active' : '' }}">
                            <div class="step-icon">📝</div>
                            <div class="step-label">Order Placed</div>
                        </div>
                        
                        <div class="progress-step {{ $currentStep >= 2 ? 'completed' : '' }} {{ $currentStep == 2 ? 'active' : '' }}">
                            <div class="step-icon">📦</div>
                            <div class="step-label">Processing</div>
                        </div>
                        
                        <div class="progress-step {{ $currentStep >= 3 ? 'completed' : '' }} {{ $currentStep == 3 ? 'active' : '' }}">
                            <div class="step-icon">✅</div>
                            <div class="step-label">Delivered</div>
                        </div>
                    </div>
                </div>
            @else
                <div class="cancelled-message">
                    <div class="icon">❌</div>
                    <h3>Order Cancelled</h3>
                    <p>This order has been cancelled. If you have any questions, please contact us.</p>
                </div>
            @endif

            <!-- Info Grid -->
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Customer Name</div>
                    <div class="info-value">{{ $order->customer_name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Phone Number</div>
                    <div class="info-value">{{ $order->customer_phone }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Delivery Location</div>
                    <div class="info-value">{{ $order->delivery_location === 'inside_dhaka' ? 'Inside Dhaka' : 'Outside Dhaka' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Quantity</div>
                    <div class="info-value">{{ $order->quantity }} item(s)</div>
                </div>
            </div>

            <!-- Product -->
            <div class="product-section">
                @if($order->product->primaryImage)
                    <img src="{{ asset('storage/' . $order->product->primaryImage) }}" alt="{{ $order->product->name }}" class="product-image">
                @else
                    <div class="product-image bg-gray-200 flex items-center justify-center text-gray-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
                <div class="product-info">
                    <div class="product-name">{{ $order->product->name }}</div>
                    <div class="product-meta">{{ $order->quantity }} x ৳{{ number_format($order->product->finalPrice, 2) }}</div>
                    @if($order->customer_email)
                        <div class="product-meta">Email: {{ $order->customer_email }}</div>
                    @endif
                    <div class="product-price">৳{{ number_format($order->product->finalPrice * $order->quantity, 2) }}</div>
                </div>
            </div>

            <!-- Delivery Address -->
            <div style="background: #f9fafb; padding: 16px; border-radius: 10px; margin-bottom: 16px;">
                <div class="info-label">Delivery Address</div>
                <div class="info-value" style="margin-top: 4px;">{{ $order->customer_address }}</div>
            </div>

            <!-- Totals -->
            <div class="total-section">
                <div class="total-row">
                    <span class="total-label">Subtotal</span>
                    <span class="total-value">৳{{ number_format($order->total_amount - $order->delivery_charge, 2) }}</span>
                </div>
                <div class="total-row">
                    <span class="total-label">Delivery Charge</span>
                    <span class="total-value">৳{{ number_format($order->delivery_charge, 2) }}</span>
                </div>
                <div class="total-final">
                    <span class="total-final-label">Total Amount</span>
                    <span class="total-final-value">৳{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div style="text-align: center;">
            <a href="{{ route('track-order') }}" class="btn-back">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Track Order
            </a>
        </div>
    </div>
@endsection
