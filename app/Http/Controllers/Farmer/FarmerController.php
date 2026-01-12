<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FarmerController extends Controller
{
   public function register(Request $request)
   {

   $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|unique:users',
    'password' => 'required|string|min:4',
    'phone'=> "required|string",
    'address'=> "required|string",
    'business_name' => 'required|string|max:255',
    'has_delivery' => 'sometimes|boolean',
]);
    $user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'phone' => $request->phone,
    'address' => $request->address,
    'role' => 'farmer',
]);

$user->farmer()->create([
    'business_name' => $request->business_name,
    'has_delivery' => $request->has_delivery ?? false,
]);

return response()->json([
    'status' => true,
    'message' => 'Farmer created successfully',
    'user' => $user->fresh() 
], 201);
   }
}
