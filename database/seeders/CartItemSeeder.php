<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cart = Cart::where('status', 'active')->first();
        $products = Product::take(3)->get();

        if (!$cart || $products->isEmpty()) {
            $this->command->warn('No cart or products found, Cart items not created');
            return;
        }

        foreach ($products as $product) {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => rand(1, 5), 
            ]);
        }
    }
}
