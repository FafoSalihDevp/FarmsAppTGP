<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

     $user = User::where('role', 'farmer')->first();

     
        if (!$user) {
            $this->command->error('No farmer found in users table');
            return;
        }

         Product::create([
            'name' => 'Tomatoes',
            'description' => 'Organic fresh tomatoes from the farm',
            'price' => 5.50,
            'is_available' => true,
            'user_id' => $user->id,
            'category_id' => 1,
        ]);



        $user = User::where('role', 'customer')->first();

     
        if (!$user) {
            $this->command->error('No customer found in users table');
            return;
        }

         Product::create([
            'name' => 'Tomatoes',
            'description' => 'Organic fresh tomatoes from the farm',
            'price' => 5.50,
            'is_available' => true,
            'user_id' => $user->id,
            'category_id' => 2,
        ]);
    }
}
