<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CustomerProductController extends Controller
{
    
    public function index()
    {
        //  $user = Auth::user();
        // return User::findOrFail($user->id)->load('products');

        //  {
        $user = Auth::user();

        $products = $user->products()->with('category')->get();

        return response()->json([
            'status' => true,
            'products' => $products
        ]);

        
    }

   
    public function store(Request $request)
    {
        //
    }

   
    public function show(string $id)
    {
        //
    }

   
    public function update(Request $request, string $id)
    {
        //
    }

   
    public function destroy(string $id)
    {
        //
    }
}
