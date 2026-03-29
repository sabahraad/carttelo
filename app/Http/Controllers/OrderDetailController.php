<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderDetailController extends Controller
{
    public function show(Order $order)
    {
        $order->load('product', 'product.images');
        
        $statusSteps = [
            'pending' => ['label' => 'Pending', 'color' => 'yellow', 'icon' => '⏳'],
            'processing' => ['label' => 'Processing', 'color' => 'blue', 'icon' => '📦'],
            'delivered' => ['label' => 'Delivered', 'color' => 'green', 'icon' => '✅'],
            'cancelled' => ['label' => 'Cancelled', 'color' => 'red', 'icon' => '❌'],
        ];
        
        return view('order-detail', compact('order', 'statusSteps'));
    }
}
