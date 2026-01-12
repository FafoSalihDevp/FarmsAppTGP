<?php

namespace App\Http\Controllers\Customer;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    public function checkout(Request $request)
    {
        $user = Auth::user();

        $cart = Cart::where('user_id', $user->id)
                    ->where('status', 'active')
                    ->with('items.product')
                    ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Cart is empty'
            ], 400);
        }

      
        $total = $cart->items->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

       
        $order = Order::create([
            'user_id' => $user->id,
            'total' => $total,
            'status' => 'pending',
        ]);

       
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

      
        $cart->items()->delete();
        $cart->update(['status' => 'ordered']);

        return response()->json([
            'status' => true,
            'message' => 'Order created successfully',
            'order_id' => $order->id,
            'total' => $order->total
        ], 201);
    }


    public function myOrders()
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
                    ->with('items.product')
                    ->get();

        return response()->json([
            'status' => true,
            'orders' => $orders
        ]);
    }

    
    public function orderDetails($id)
    {
        $user = Auth::user();

        $order = Order::where('id', $id)
                    ->where('user_id', $user->id)
                    ->with('items.product')
                    ->first();

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'order' => $order
        ]);
    }
}
