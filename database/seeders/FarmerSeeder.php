<?php

namespace Database\Seeders;

use App\Models\Farmer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FarmerSeeder extends Seeder
{
 
    public function run(): void
    {
          $user = User::create([
            'name' => 'hana',
            'email' => 'hana@gmail.com',
            'password' => Hash::make('1234'),
            'phone' => '0123456789',
            'address' => 'darna',
            'role' => 'farmer',
        ]);

      
        Farmer::create([
            'user_id' => $user->id,
            'business_name' => 'green farm',
            'has_delivery' => false,
        ]);
    }
}
