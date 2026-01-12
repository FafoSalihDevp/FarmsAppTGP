<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    
    public function run(): void
    {
        $user = User::where('role', 'customer')->first();

        if (!$user) {
            $this->command->warn('No customer found. Cart not created.');
            return;
        }

        Cart::create([
            'user_id' => $user->id,
            'status' => 'active',
        ]);
    }
}
