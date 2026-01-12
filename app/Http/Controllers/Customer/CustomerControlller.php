<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerControlller extends Controller
{
     public function register(Request $request)
   {

   $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|unique:users',
    'password' => 'required|string|min:4',
    'phone'=> "required|string",
    'address'=> "required|string",
    
]);
    $user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'phone' => $request->phone,
    'address' => $request->address,
    'role' => 'customer',
]);



return response()->json([
    'status' => true,
    'message' => 'customer created successfully',
    'user' => $user->fresh() 
], 201);
   }
}


