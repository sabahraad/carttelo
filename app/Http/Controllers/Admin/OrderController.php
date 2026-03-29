<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('product');

        if ($request->has('status') && in_array($request->status, ['pending', 'processing', 'delivered', 'cancelled'])) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(20);
        $statuses = ['pending', 'processing', 'delivered', 'cancelled'];

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order)
    {
        $order->load('product', 'product.images');
        $statuses = [
            'pending' => ['label' => 'Pending', 'color' => 'yellow', 'icon' => '⏳'],
            'processing' => ['label' => 'Processing', 'color' => 'blue', 'icon' => '📦'],
            'delivered' => ['label' => 'Delivered', 'color' => 'green', 'icon' => '✅'],
            'cancelled' => ['label' => 'Cancelled', 'color' => 'red', 'icon' => '❌'],
        ];
        
        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        $order->update(['status' => $newStatus]);

        // If order is cancelled, restore stock
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            $order->product->increment('stock');
        }

        // If order was cancelled and now is not, decrease stock
        if ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
            $order->product->decrement('stock');
        }

        return redirect()->back()
            ->with('success', 'Order status updated to ' . ucfirst($newStatus) . ' successfully.');
    }
}
