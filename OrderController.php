<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // eager load the customer and items with the product
        $orders = Order::with(['customer', 'items.product'])->get();			
        $orderData = [];

        foreach ($orders as $order) {
            $totalAmount = 0;
            $itemsCount = 0;

            foreach ($order->items as $item) {
                $totalAmount += $item->price * $item->quantity;
                $itemsCount++;
            }

            $lastAddedToCart = CartItem::where('order_id', $order->id)
                ->orderByDesc('created_at')
                ->value('created_at');

            // directly access the status attribute to avoid n+1 queries
            $completedOrderExists = $order->status === 'completed';

            $orderData[] = [
                'order_id' => $order->id,
                'customer_name' => $order->customer->name,
                'total_amount' => $totalAmount,
                'items_count' => $itemsCount,
                'last_added_to_cart' => $lastAddedToCart,
                'completed_order_exists' => $completedOrderExists,
                'created_at' => $order->created_at,
                'completed_at' => $order->completed_at ?? null,
            ];
        }

        // simplify sorting by completed_at
        usort($orderData, function($a, $b) {
            return strtotime($b['completed_at']) - strtotime($a['completed_at']);
        });

        return view('orders.index', ['orders' => $orderData]);
    }
}

