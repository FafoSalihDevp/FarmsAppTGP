<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class FarmerCategoryController extends Controller
{
     public function index()
    {
        $categories = Category::all();
        return $categories;
    }
}
