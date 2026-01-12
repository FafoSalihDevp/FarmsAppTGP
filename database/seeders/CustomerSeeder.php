<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $user = User::create([
            'name' => 'aiman',
            'email' => 'aiman@gmail.com',
            'password' => Hash::make('1234'),
            'phone' => '0987654321',
            'address' => 'benghazi',
            'role' => 'customer',
        ]);

        
        Customer::create([
            'user_id' => $user->id,
        ]);
    }
}
