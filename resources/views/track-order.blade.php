@extends('layouts.app')

@section('title', 'Track Your Order')

@section('content')
    <style>
        .track-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .track-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .track-header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }
        .track-header p {
            color: #6b7280;
            font-size: 16px;
        }
        
        /* Search Box */
        .search-box {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 32px;
        }
        .search-input-wrapper {
            display: flex;
            gap: 12px;
        }
        .search-input {
            flex: 1;
            padding: 14px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.2s;
        }
        .search-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .search-btn {
            padding: 14px 32px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .search-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.3);
        }
        
        /* Order Card */
        .order-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f3f4f6;
        }
        .order-id {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
        }
        .order-date {
            font-size: 14px;
            color: #6b7280;
            margin-top: 4px;
        }
        .order-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-processing { background: #dbeafe; color: #1e40af; }
        .status-delivered { background: #dcfce7; color: #166534; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        
        /* Progress Bar */
        .progress-container {
            margin: 24px 0;
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
        
        /* Product Info */
        .product-row {
            display: flex;
            gap: 16px;
            padding: 16px;
            background: #f9fafb;
            border-radius: 12px;
            margin-top: 16px;
        }
        .product-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
        }
        .product-details {
            flex: 1;
        }
        .product-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
        }
        .product-meta {
            font-size: 14px;
            color: #6b7280;
        }
        .product-price {
            font-size: 18px;
            font-weight: 700;
            color: #3b82f6;
            margin-top: 8px;
        }
        
        /* View Details Button */
        .btn-details {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #f3f4f6;
            color: #374151;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
            margin-top: 16px;
        }
        .btn-details:hover {
            background: #e5e7eb;
        }
        
        /* No Results */
        .no-results {
            text-align: center;
            padding: 60px 20px;
        }
        .no-results-icon {
            font-size: 64px;
            margin-bottom: 16px;
        }
        .no-results h3 {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }
        .no-results p {
            color: #6b7280;
        }
    </style>

    <div class="track-container">
        <div class="track-header">
            <h1>Track Your Order</h1>
            <p>Enter your phone number to see your order status</p>
        </div>

        <!-- Search Form -->
        <div class="search-box">
            <form action="{{ route('track-order.search') }}" method="POST">
                @csrf
                <div class="search-input-wrapper">
                    <input type="tel" name="phone" class="search-input" 
                           placeholder="Enter your phone number (e.g., 01XXXXXXXXX)" 
                           value="{{ $phone ?? '' }}"
                           required>
                    <button type="submit" class="search-btn">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Track Order
                    </button>
                </div>
            </form>
        </div>

        <!-- Results -->
        @if(isset($orders))
            @if($orders->count() > 0)
                <div class="results-header" style="margin-bottom: 20px;">
                    <h2 style="font-size: 20px; font-weight: 600; color: #1f2937;">
                        Found {{ $orders->count() }} order(s)
                    </h2>
                </div>

                @foreach($orders as $order)
                    @php
                        $currentStep = $statusSteps[$order->status]['step'];
                        $progressWidth = $order->status === 'cancelled' ? 0 : (($currentStep - 1) / 2) * 100;
                    @endphp
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <div class="order-id">Order #{{ $order->id }}</div>
                                <div class="order-date">{{ $order->created_at->format('F d, Y h:i A') }}</div>
                            </div>
                            <div class="order-status-badge status-{{ $order->status }}">
                                {{ $statusSteps[$order->status]['icon'] }} {{ $statusSteps[$order->status]['label'] }}
                            </div>
                        </div>

                        @if($order->status !== 'cancelled')
                            <!-- Progress Bar -->
                            <div class="progress-container">
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
                            <div style="background: #fee2e2; color: #991b1b; padding: 16px; border-radius: 8px; text-align: center; margin: 16px 0;">
                                <span style="font-size: 24px;">❌</span>
                                <p style="margin-top: 8px; font-weight: 600;">This order has been cancelled</p>
                            </div>
                        @endif

                        <!-- Product Info -->
                        <div class="product-row">
                            @if($order->product->primaryImage)
                                <img src="{{ asset('storage/' . $order->product->primaryImage) }}" alt="{{ $order->product->name }}" class="product-image">
                            @else
                                <div class="product-image bg-gray-200 flex items-center justify-center text-gray-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="product-details">
                                <div class="product-name">{{ $order->product->name }}</div>
                                <div class="product-meta">Qty: {{ $order->quantity }} | {{ $order->delivery_location === 'inside_dhaka' ? 'Inside Dhaka' : 'Outside Dhaka' }}</div>
                                <div class="product-price">৳{{ number_format($order->total_amount, 2) }}</div>
                            </div>
                        </div>

                        <!-- View Details Button -->
                        <div style="text-align: center;">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn-details" target="_blank">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View Full Details
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="no-results">
                    <div class="no-results-icon">📦</div>
                    <h3>No orders found</h3>
                    <p>We couldn't find any orders with the phone number "{{ $phone }}". Please check and try again.</p>
                </div>
            @endif
        @endif
    </div>
@endsection
