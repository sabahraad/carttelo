<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request)
    {
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;

        if ($product->stock < $quantity) {
            return redirect()->back()
                ->with('error', 'Sorry, only ' . $product->stock . ' item(s) available in stock.');
        }

        // Calculate prices
        $unitPrice = $product->finalPrice ?? 0;
        $subtotal = $unitPrice * $quantity;
        
        // Get delivery charge (0 if product has free delivery)
        $insideDhaka = $request->delivery_location === 'inside_dhaka';
        $deliveryCharge = $product->free_delivery ? 0 : Setting::getDeliveryCharge($insideDhaka);
        
        // Calculate total
        $totalAmount = $subtotal + $deliveryCharge;

        // Create order with all data
        $orderData = $request->validated();
        $orderData['delivery_charge'] = $deliveryCharge;
        $orderData['total_amount'] = $totalAmount;

        Order::create($orderData);

        // Decrease stock
        $product->decrement('stock', $quantity);

        return redirect()->route('track-order', ['phone' => $orderData['customer_phone']])
            ->with('success', 'Your order for ' . $quantity . ' item(s) has been placed successfully! We will contact you soon.');
    }
}
