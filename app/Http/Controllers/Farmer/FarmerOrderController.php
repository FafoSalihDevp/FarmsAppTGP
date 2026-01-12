<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FarmerOrderController extends Controller
{
   
    public function showOrder()
    {
       $farmer = Auth::user();

    $orders = Order::whereHas('items.product', function ($q) use ($farmer) {
        $q->where('user_id', $farmer->id);
    })
    ->with(['items.product' => function ($q) use ($farmer) {
        $q->where('user_id', $farmer->id);
    }, 'user'])
    ->get()
    ->map(function($order) {
        return [
            'order_id' => $order->id,
            'status' => $order->status,
            'total' => $order->total,
            'customer' => [
                'id' => $order->user->id,
                'name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone,
            ],
            'items' => $order->items->map(function($item) {
                return [
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ];
            }),
        ];
    });

    return response()->json([
        'status' => true,
        'orders' => $orders
    ]);
    }

    
    

    public function updateStatus(Request $request, $orderId)
{
    $farmer = Auth::user();

    $request->validate([
        'status' => 'required|in:pending,completed,canceled'
    ]);

    $order = Order::where('id', $orderId)
        ->whereHas('items.product', function ($q) use ($farmer) {
            $q->where('user_id', $farmer->id);
        })
        ->first();

    if (!$order) {
        return response()->json([
            'status' => false,
            'message' => 'order not found or not yours'
        ], 404);
    }

    $order->update([
        'status' => $request->status
    ]);

    return response()->json([
        'status' => true,
        'message' => 'order status updated',
        'order' => $order
    ]);
}
}

