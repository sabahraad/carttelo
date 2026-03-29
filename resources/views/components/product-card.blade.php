@props(['product'])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <a href="{{ route('product.show', $product) }}">
        <div class="aspect-w-16 aspect-h-9 bg-gray-200 relative">
            @if ($product->primaryImage)
                <img src="{{ asset('storage/' . $product->primaryImage) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 flex items-center justify-center bg-gray-100 text-gray-400">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            @endif
            
            <!-- Discount Badge -->
            @if ($product->hasDiscount())
                <div class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                    -{{ $product->discountPercentage }}%
                </div>
            @endif
        </div>
    </a>
    
    <div class="p-4">
        <a href="{{ route('product.show', $product) }}">
            <h3 class="text-lg font-semibold text-gray-900 hover:text-blue-600 transition line-clamp-1">
                {{ $product->name }}
            </h3>
        </a>
        
        @if ($product->description)
            <p class="mt-2 text-gray-600 text-sm line-clamp-2">
                {{ Str::limit($product->description, 80) }}
            </p>
        @endif
        
        <!-- Price -->
        <div class="mt-3">
            @if ($product->sell_price)
                <div class="flex items-center gap-2">
                    <span class="text-xl font-bold text-gray-900">
                        ৳{{ number_format($product->finalPrice, 0) }}
                    </span>
                    @if ($product->hasDiscount())
                        <span class="text-sm text-gray-400 line-through">
                            ৳{{ number_format($product->sell_price, 0) }}
                        </span>
                    @endif
                </div>
            @else
                <span class="text-sm text-gray-400">Price not set</span>
            @endif
        </div>
        
        <div class="mt-4 flex items-center justify-between">
            <span class="text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                @if ($product->stock > 0)
                    ✓ In Stock ({{ $product->stock }})
                @else
                    ✗ Out of Stock
                @endif
            </span>
            
            <a href="{{ route('product.show', $product) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                View Details
            </a>
        </div>
    </div>
</div>
