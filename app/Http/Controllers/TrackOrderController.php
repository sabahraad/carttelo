<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackOrderController extends Controller
{
    public function index(Request $request)
    {
        $phone = $request->query('phone');
        
        // If phone is provided in query, auto-search
        if ($phone) {
            $orders = Order::with('product')
                ->where('customer_phone', $phone)
                ->orWhere('customer_phone', 'like', '%' . $phone . '%')
                ->latest()
                ->get();

            $statusSteps = [
                'pending' => ['step' => 1, 'label' => 'Order Placed', 'icon' => '📝'],
                'processing' => ['step' => 2, 'label' => 'Processing', 'icon' => '📦'],
                'delivered' => ['step' => 3, 'label' => 'Delivered', 'icon' => '✅'],
                'cancelled' => ['step' => 0, 'label' => 'Cancelled', 'icon' => '❌'],
            ];

            return view('track-order', compact('orders', 'phone', 'statusSteps'));
        }
        
        return view('track-order');
    }

    public function track(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
        ]);

        $phone = $request->phone;
        
        $orders = Order::with('product')
            ->where('customer_phone', $phone)
            ->orWhere('customer_phone', 'like', '%' . $phone . '%')
            ->latest()
            ->get();

        $statusSteps = [
            'pending' => ['step' => 1, 'label' => 'Order Placed', 'icon' => '📝'],
            'processing' => ['step' => 2, 'label' => 'Processing', 'icon' => '📦'],
            'delivered' => ['step' => 3, 'label' => 'Delivered', 'icon' => '✅'],
            'cancelled' => ['step' => 0, 'label' => 'Cancelled', 'icon' => '❌'],
        ];

        return view('track-order', compact('orders', 'phone', 'statusSteps'));
    }
}
