<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerCartController extends Controller
{
    // view user cart
     public function myCart()
    {
        $cart = Cart::where('user_id', Auth::id())
                ->where('status','active')
                ->with('items.product')
                ->first();

        return response()->json([
            'status' => true,
            'cart' => $cart
        ]);
    }

    // add cart 
     public function addToCart(Request $request)
    {
        $request->validate([
            'product_id'=>'required|exists:products,id',
            'quantity'=>'required|integer|min:1'
        ]);

        $cart = Cart::firstOrCreate([
            'user_id'=>Auth::id(),
            'status'=>'active'
        ]);

        $item = CartItem::where('cart_id',$cart->id)
                        ->where('product_id',$request->product_id)
                        ->first();

        if($item){
            $item->quantity += $request->quantity;
            $item->save();
        }else{
            CartItem::create([
                'cart_id'=>$cart->id,
                'product_id'=>$request->product_id,
                'quantity'=>$request->quantity
            ]);
        }

        return response()->json(['status'=>true,'message'=>'Added to cart']);
    }


    // remove otem
      public function removeItem($id)
    {
        CartItem::where('id',$id)->delete();
        return response()->json([
            'message' => 'item removed',
            'status'=>true
            ]);
    }
}
