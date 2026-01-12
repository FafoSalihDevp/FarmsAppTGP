<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => Hash::make('12345678'),
        'phone' => '0123456789',     
        'address' => 'Libya',   
        'role' => 'customer',   
        ]);

         User::create([
        'name' => 'fafo',
        'email' => 'fafo@gmail.com',
        'password' => Hash::make('1234'),
        'phone' => '0123456789',     
        'address' => 'Libya',   
        'role' => 'farmer',   
        ]);
    }
}
