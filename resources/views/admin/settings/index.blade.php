@extends('layouts.admin')

@section('title', 'Settings')
@section('page_title', 'Delivery Charges')

@section('content')
    <style>
        .form-section {
            background: white;
            border-radius: 16px;
            padding: 32px;
            border: 1px solid #e5e7eb;
            max-width: 600px;
        }
        .section-header {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f3f4f6;
        }
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
        }
        .section-subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-top: 4px;
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
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
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
        .price-input-wrapper {
            position: relative;
        }
        .price-input-wrapper .currency {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-weight: 600;
        }
        .price-input-wrapper input {
            padding-left: 40px;
        }
        
        /* Submit Button */
        .btn {
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
        
        /* Info Card */
        .info-card {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 24px;
        }
        .info-card-title {
            font-weight: 600;
            color: #0369a1;
            margin-bottom: 4px;
        }
        .info-card-text {
            font-size: 14px;
            color: #0ea5e9;
        }
    </style>

    <div class="form-section">
        <div class="section-header">
            <h3 class="section-title">Delivery Charges</h3>
            <p class="section-subtitle">Set delivery rates for different locations</p>
        </div>

        <div class="info-card">
            <div class="info-card-title">ℹ️ How it works</div>
            <div class="info-card-text">
                Customers will see these delivery charges when placing orders. 
                The charges will be automatically added to their order total.
            </div>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Inside Dhaka -->
                <div class="form-group">
                    <label for="delivery_inside_dhaka" class="form-label">
                        Inside Dhaka Delivery Charge
                    </label>
                    <div class="price-input-wrapper">
                        <span class="currency">৳</span>
                        <input type="number" name="delivery_inside_dhaka" id="delivery_inside_dhaka" 
                               value="{{ old('delivery_inside_dhaka', $settings['delivery_inside_dhaka']) }}"
                               min="0"
                               step="0.01"
                               class="form-input @error('delivery_inside_dhaka') error @enderror"
                               placeholder="60.00"
                               required>
                    </div>
                    <p class="input-hint">Delivery charge for addresses within Dhaka city</p>
                    @error('delivery_inside_dhaka')
                        <p class="error-message">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Outside Dhaka -->
                <div class="form-group">
                    <label for="delivery_outside_dhaka" class="form-label">
                        Outside Dhaka Delivery Charge
                    </label>
                    <div class="price-input-wrapper">
                        <span class="currency">৳</span>
                        <input type="number" name="delivery_outside_dhaka" id="delivery_outside_dhaka" 
                               value="{{ old('delivery_outside_dhaka', $settings['delivery_outside_dhaka']) }}"
                               min="0"
                               step="0.01"
                               class="form-input @error('delivery_outside_dhaka') error @enderror"
                               placeholder="120.00"
                               required>
                    </div>
                    <p class="input-hint">Delivery charge for addresses outside Dhaka city</p>
                    @error('delivery_outside_dhaka')
                        <p class="error-message">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Save Delivery Charges
            </button>
        </form>
    </div>
@endsection
