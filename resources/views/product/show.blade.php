@extends('layouts.app')

@php
use App\Models\Setting;
$insideDhakaCharge = Setting::getDeliveryCharge(true);
$outsideDhakaCharge = Setting::getDeliveryCharge(false);
@endphp

@section('title', $product->name)

@section('content')
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <style>
        /* Medium Zoom CSS */
        .medium-zoom-overlay {
            position: fixed;
            top: 0; right: 0; bottom: 0; left: 0;
            opacity: 0;
            transition: opacity 300ms;
            background: rgba(0, 0, 0, 0.9);
            z-index: 50;
        }
        .medium-zoom--opened .medium-zoom-overlay {
            cursor: pointer;
            opacity: 1;
        }
        .medium-zoom-image {
            cursor: zoom-in;
            transition: transform 300ms cubic-bezier(0.2, 0, 0.2, 1);
        }
        .medium-zoom-image--opened {
            position: fixed;
            cursor: pointer;
            z-index: 51;
        }
        
        /* Swiper styles */
        .product-swiper {
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
        }
        .product-swiper .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f3f4f6;
            aspect-ratio: 1;
        }
        .product-swiper .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .product-thumbs {
            margin-top: 12px;
        }
        .product-thumbs .swiper-slide {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            opacity: 0.6;
            border: 2px solid transparent;
        }
        .product-thumbs .swiper-slide-thumb-active {
            opacity: 1;
            border-color: #2563eb;
        }
        .swiper-button-next, .swiper-button-prev {
            color: white;
            background: rgba(0,0,0,0.3);
            width: 44px;
            height: 44px;
            border-radius: 50%;
        }
        .swiper-button-next:after, .swiper-button-prev:after {
            font-size: 18px;
        }
        
        /* Order Form Styles */
        .order-section {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 24px;
            padding: 40px;
        }
        .form-group {
            margin-bottom: 24px;
        }
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }
        .form-label span.required {
            color: #ef4444;
            margin-left: 2px;
        }
        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.2s;
            background: white;
        }
        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .form-input.error {
            border-color: #ef4444;
        }
        .form-input::placeholder {
            color: #9ca3af;
        }
        .input-hint {
            font-size: 12px;
            color: #6b7280;
            margin-top: 6px;
        }
        .error-message {
            font-size: 13px;
            color: #ef4444;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        /* Quantity Selector */
        .quantity-wrapper {
            display: inline-flex;
            align-items: center;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }
        .quantity-btn {
            width: 44px;
            height: 44px;
            border: none;
            background: #f9fafb;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }
        .quantity-btn:hover {
            background: #f3f4f6;
        }
        .quantity-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .quantity-input {
            width: 60px;
            height: 44px;
            border: none;
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
        }
        .quantity-input:focus {
            outline: none;
        }
        .stock-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            background: #dcfce7;
            color: #166534;
            font-size: 13px;
            font-weight: 500;
            border-radius: 20px;
            margin-left: 12px;
        }
        
        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 16px 24px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.3);
        }
        .submit-btn:active {
            transform: translateY(0);
        }
        
        /* COD Badge */
        .cod-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            background: #fef3c7;
            color: #92400e;
            font-size: 14px;
            border-radius: 10px;
            margin-top: 16px;
        }
        
        /* Section Title */
        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }
        .section-subtitle {
            font-size: 15px;
            color: #6b7280;
            margin-bottom: 32px;
        }
        
        /* Price Display */
        .price-container {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
        }
        .price-row {
            display: flex;
            align-items: baseline;
            gap: 16px;
            flex-wrap: wrap;
        }
        .final-price {
            font-size: 36px;
            font-weight: 800;
            color: #1f2937;
        }
        .final-price .currency {
            font-size: 20px;
            font-weight: 600;
        }
        .original-price {
            font-size: 20px;
            color: #9ca3af;
            text-decoration: line-through;
        }
        .discount-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            background: #ef4444;
            color: white;
            font-size: 14px;
            font-weight: 600;
            border-radius: 20px;
        }
        
        /* Delivery Location */
        .delivery-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .delivery-option {
            position: relative;
        }
        .delivery-option input {
            position: absolute;
            opacity: 0;
        }
        .delivery-option label {
            display: block;
            padding: 16px;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .delivery-option input:checked + label {
            border-color: #3b82f6;
            background: #eff6ff;
        }
        .delivery-option-title {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
        }
        .delivery-option-price {
            font-size: 14px;
            color: #6b7280;
        }
        .delivery-option input:checked + label .delivery-option-title {
            color: #3b82f6;
        }
        
        /* Product Info Card */
        .product-info-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid #e5e7eb;
        }
        .product-info-title {
            font-size: 13px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .product-info-value {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Product Images Slider -->
            <div>
                @if ($product->images->count() > 0)
                    <div class="swiper product-swiper">
                        <div class="swiper-wrapper">
                            @foreach ($product->images as $image)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                         alt="{{ $product->name }}" 
                                         class="zoom-image"
                                         data-zoom-src="{{ asset('storage/' . $image->image_path) }}">
                                </div>
                            @endforeach
                        </div>
                        @if ($product->images->count() > 1)
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-pagination"></div>
                        @endif
                    </div>

                    @if ($product->images->count() > 1)
                        <div class="swiper product-thumbs">
                            <div class="swiper-wrapper">
                                @foreach ($product->images as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    <div class="w-full h-96 flex items-center justify-center bg-gray-100 rounded-2xl text-gray-400">
                        <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                
                <!-- Price Display -->
                @if ($product->sell_price)
                    <div class="price-container">
                        <div class="price-row">
                            <span class="final-price">
                                <span class="currency">৳</span>{{ number_format($product->finalPrice, 2) }}
                            </span>
                            @if ($product->hasDiscount())
                                <span class="original-price">৳{{ number_format($product->sell_price, 2) }}</span>
                                <span class="discount-badge">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    {{ $product->discountPercentage }}% OFF
                                </span>
                            @endif
                        </div>
                        @if ($product->hasDiscount())
                            <p class="text-sm text-gray-600 mt-2">You save ৳{{ number_format($product->sell_price - $product->discount_price, 2) }}</p>
                        @endif
                    </div>
                @endif
                
                <div class="flex items-center gap-3 mb-6">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $product->stock > 0 ? '✓ In Stock' : '✗ Out of Stock' }}
                    </span>
                    <span class="text-gray-500">{{ $product->stock }} items available</span>
                </div>

                @if ($product->description)
                    <div class="prose prose-blue mb-8">
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>
                @endif

                @if ($product->video_url)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Product Video</h3>
                        <div class="aspect-w-16 aspect-h-9 rounded-xl overflow-hidden bg-gray-900">
                            @php
                                $videoId = '';
                                if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\s]+)/', $product->video_url, $matches)) {
                                    $videoId = $matches[1];
                                }
                            @endphp
                            @if ($videoId)
                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" 
                                        title="Product Video" frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen class="w-full h-64 lg:h-72 rounded-xl"></iframe>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Order Form Section -->
        <div class="mt-16">
            <div class="order-section">
                <div class="max-w-2xl mx-auto">
                    <div class="text-center mb-8">
                        <h2 class="section-title">Place Your Order</h2>
                        <p class="section-subtitle">Fill in your details below and we'll deliver to your doorstep</p>
                    </div>
                    
                    @if ($product->stock > 0)
                        <!-- Product Summary -->
                        <div class="product-info-card">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <div class="product-info-title">Ordering</div>
                                    <div class="product-info-value">{{ $product->name }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="product-info-title">Available Stock</div>
                                    <div class="product-info-value text-green-600">{{ $product->stock }} pcs</div>
                                </div>
                            </div>
                            @if ($product->sell_price)
                                <div class="border-t border-gray-200 pt-4 mt-4 space-y-3">
                                    <div class="flex items-center justify-between">
                                        <div class="product-info-title">Unit Price</div>
                                        <div class="product-info-value">
                                            ৳{{ number_format($product->finalPrice, 2) }}
                                            @if ($product->hasDiscount())
                                                <span class="text-sm text-gray-400 line-through ml-2">৳{{ number_format($product->sell_price, 2) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="product-info-title">Subtotal</div>
                                        <div class="product-info-value" id="subtotalPrice">
                                            ৳{{ number_format($product->finalPrice, 2) }}
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="product-info-title">Delivery Charge</div>
                                        <div class="product-info-value" id="deliveryCharge">
                                            ৳{{ number_format($insideDhakaCharge, 2) }}
                                        </div>
                                    </div>
                                    <div class="border-t border-gray-200 pt-3 mt-3">
                                        <div class="flex items-center justify-between">
                                            <div class="product-info-title">Total Amount</div>
                                            <div class="product-info-value text-blue-600 text-2xl" id="totalPrice">
                                                ৳{{ number_format($product->finalPrice + $insideDhakaCharge, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <form action="{{ route('order.store') }}" method="POST" id="orderForm">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <!-- Quantity -->
                            <div class="form-group">
                                <label class="form-label">
                                    Quantity <span class="required">*</span>
                                </label>
                                <div class="flex items-center">
                                    <div class="quantity-wrapper">
                                        <button type="button" class="quantity-btn" onclick="updateQuantity(-1)" id="qtyMinus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" 
                                               min="1" max="{{ $product->stock }}" class="quantity-input" readonly>
                                        <button type="button" class="quantity-btn" onclick="updateQuantity(1)" id="qtyPlus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <span class="stock-badge">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        {{ $product->stock }} available
                                    </span>
                                </div>
                                @error('quantity')
                                    <p class="error-message">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Delivery Location -->
                            <div class="form-group">
                                <label class="form-label">
                                    Delivery Location <span class="required">*</span>
                                </label>
                                <div class="delivery-options">
                                    <div class="delivery-option">
                                        <input type="radio" name="delivery_location" id="inside_dhaka" value="inside_dhaka" 
                                               {{ old('delivery_location', 'inside_dhaka') === 'inside_dhaka' ? 'checked' : '' }}
                                               onchange="updateDeliveryCharge()">
                                        <label for="inside_dhaka">
                                            <div class="delivery-option-title">Inside Dhaka</div>
                                            <div class="delivery-option-price">৳{{ number_format($insideDhakaCharge, 0) }}</div>
                                        </label>
                                    </div>
                                    <div class="delivery-option">
                                        <input type="radio" name="delivery_location" id="outside_dhaka" value="outside_dhaka"
                                               {{ old('delivery_location') === 'outside_dhaka' ? 'checked' : '' }}
                                               onchange="updateDeliveryCharge()">
                                        <label for="outside_dhaka">
                                            <div class="delivery-option-title">Outside Dhaka</div>
                                            <div class="delivery-option-price">৳{{ number_format($outsideDhakaCharge, 0) }}</div>
                                        </label>
                                    </div>
                                </div>
                                @error('delivery_location')
                                    <p class="error-message">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Name & Phone Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div class="form-group">
                                    <label for="customer_name" class="form-label">
                                        Full Name <span class="required">*</span>
                                    </label>
                                    <input type="text" name="customer_name" id="customer_name" 
                                           value="{{ old('customer_name') }}"
                                           class="form-input @error('customer_name') error @enderror"
                                           placeholder="Enter your full name"
                                           required>
                                    @error('customer_name')
                                        <p class="error-message">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="form-group">
                                    <label for="customer_phone" class="form-label">
                                        Phone Number <span class="required">*</span>
                                    </label>
                                    <input type="tel" name="customer_phone" id="customer_phone"
                                           value="{{ old('customer_phone') }}"
                                           class="form-input @error('customer_phone') error @enderror"
                                           placeholder="01XXXXXXXXX"
                                           required>
                                    <p class="input-hint">We'll contact you on this number</p>
                                    @error('customer_phone')
                                        <p class="error-message">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="customer_email" class="form-label">
                                    Email Address <span style="color: #9ca3af; font-weight: 400;">(Optional)</span>
                                </label>
                                <input type="email" name="customer_email" id="customer_email"
                                       value="{{ old('customer_email') }}"
                                       class="form-input @error('customer_email') error @enderror"
                                       placeholder="your@email.com">
                                <p class="input-hint">For order updates and confirmation</p>
                                @error('customer_email')
                                    <p class="error-message">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="form-group">
                                <label for="customer_address" class="form-label">
                                    Delivery Address <span class="required">*</span>
                                </label>
                                <textarea name="customer_address" id="customer_address" rows="3"
                                          class="form-input @error('customer_address') error @enderror"
                                          placeholder="Enter your full delivery address including house number, street, area, and city"
                                          required>{{ old('customer_address') }}</textarea>
                                @error('customer_address')
                                    <p class="error-message">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="submit-btn">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Place Order Now
                            </button>

                            <!-- COD Badge -->
                            <div class="text-center">
                                <div class="cod-badge">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Cash on Delivery - Pay when you receive
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Out of Stock</h3>
                            <p class="text-gray-500">This product is currently unavailable. Please check back later.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <script>
        // Quantity Controls
        const unitPrice = {{ $product->finalPrice ?? 0 }};
        const insideDhakaCharge = {{ $insideDhakaCharge }};
        const outsideDhakaCharge = {{ $outsideDhakaCharge }};
        
        function updateQuantity(change) {
            const input = document.getElementById('quantity');
            const max = parseInt(input.max);
            let value = parseInt(input.value) || 1;
            
            value += change;
            if (value < 1) value = 1;
            if (value > max) value = max;
            
            input.value = value;
            updateQuantityButtons();
            updateTotalPrice();
        }

        function updateQuantityButtons() {
            const input = document.getElementById('quantity');
            const value = parseInt(input.value);
            const max = parseInt(input.max);
            
            document.getElementById('qtyMinus').disabled = value <= 1;
            document.getElementById('qtyPlus').disabled = value >= max;
        }

        function getDeliveryCharge() {
            const isInsideDhaka = document.getElementById('inside_dhaka').checked;
            return isInsideDhaka ? insideDhakaCharge : outsideDhakaCharge;
        }

        function updateDeliveryCharge() {
            const deliveryCharge = getDeliveryCharge();
            const deliveryElement = document.getElementById('deliveryCharge');
            if (deliveryElement) {
                deliveryElement.textContent = '৳' + deliveryCharge.toFixed(2);
            }
            updateTotalPrice();
        }

        function updateTotalPrice() {
            const quantity = parseInt(document.getElementById('quantity').value) || 1;
            const deliveryCharge = getDeliveryCharge();
            
            const subtotal = quantity * unitPrice;
            const total = subtotal + deliveryCharge;
            
            const subtotalElement = document.getElementById('subtotalPrice');
            const totalElement = document.getElementById('totalPrice');
            
            if (subtotalElement) {
                subtotalElement.textContent = '৳' + subtotal.toFixed(2);
            }
            if (totalElement) {
                totalElement.textContent = '৳' + total.toFixed(2);
            }
        }

        // Initialize
        updateQuantityButtons();
        updateTotalPrice();

        // Medium Zoom
        (function() {
            const zoomImages = document.querySelectorAll('.zoom-image');
            let activeZoom = null, overlay = null, clonedImage = null;

            function createOverlay() {
                overlay = document.createElement('div');
                overlay.className = 'medium-zoom-overlay';
                document.body.appendChild(overlay);
                overlay.addEventListener('click', closeZoom);
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') closeZoom();
                });
            }

            function openZoom(img) {
                if (activeZoom) return;
                if (!overlay) createOverlay();
                
                activeZoom = img;
                document.body.classList.add('medium-zoom--opened');
                
                const rect = img.getBoundingClientRect();
                clonedImage = img.cloneNode();
                clonedImage.classList.add('medium-zoom-image--opened');
                clonedImage.style.position = 'fixed';
                clonedImage.style.top = rect.top + 'px';
                clonedImage.style.left = rect.left + 'px';
                clonedImage.style.width = rect.width + 'px';
                clonedImage.style.height = rect.height + 'px';
                
                document.body.appendChild(clonedImage);
                
                requestAnimationFrame(() => {
                    const scale = Math.min(window.innerWidth * 0.9 / rect.width, window.innerHeight * 0.9 / rect.height, 3);
                    const centerX = window.innerWidth / 2;
                    const centerY = window.innerHeight / 2;
                    const imgCenterX = rect.left + rect.width / 2;
                    const imgCenterY = rect.top + rect.height / 2;
                    
                    clonedImage.style.transition = 'transform 300ms cubic-bezier(0.2, 0, 0.2, 1)';
                    clonedImage.style.transform = `translate(${centerX - imgCenterX}px, ${centerY - imgCenterY}px) scale(${scale})`;
                });
                
                clonedImage.addEventListener('click', closeZoom);
            }

            function closeZoom() {
                if (!clonedImage) return;
                clonedImage.style.transform = 'translate(0, 0) scale(1)';
                
                setTimeout(() => {
                    if (clonedImage) {
                        clonedImage.remove();
                        clonedImage = null;
                    }
                    activeZoom = null;
                    document.body.classList.remove('medium-zoom--opened');
                }, 300);
            }

            zoomImages.forEach(img => {
                img.addEventListener('click', () => openZoom(img));
            });
        })();

        // Initialize Swiper
        document.addEventListener('DOMContentLoaded', function() {
            const thumbsSlider = document.querySelector('.product-thumbs');
            let thumbsSwiper = null;
            
            if (thumbsSlider) {
                thumbsSwiper = new Swiper('.product-thumbs', {
                    spaceBetween: 10,
                    slidesPerView: 'auto',
                    freeMode: true,
                    watchSlidesProgress: true,
                });
            }
            
            new Swiper('.product-swiper', {
                spaceBetween: 10,
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                thumbs: thumbsSwiper ? { swiper: thumbsSwiper } : null,
            });
        });
    </script>
@endsection
