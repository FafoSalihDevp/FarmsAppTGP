<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CustomerProductController extends Controller
{
    
    public function index()
    {
        
        $products = \App\Models\Product::with('category')->get();

        return response()->json([
            'status' => true,
            'products' => $products
        ]);

        
    }

   
}