<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Models\Product;
// use Illuminate\Container\Attributes\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FarmerProductController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();

        $products = $user->products()->with('category')->get();

        return response()->json([
            'status' => true,
            'products' => $products
        ]);

      
    }

  
    public function store(Request $request)
    {


    $validator = Validator::make($request->all(), [
            'name' => ['required','max:255'],
            'description' => ['required'],
            'price' => ['required','numeric','min:0'],
            'image' => ['nullable','image'],
            'is_available' => ['required','boolean'],
            'category_name' => 'required|string', 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
                ], 422);
        }

        $category = Category::firstOrCreate(['name' => $request->category_name]);
    
    $path = $request->hasFile('image') 
            ? $request->file('image')->store('products_images', 'public') 
            : null;

        $product = Product::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $path,
            'is_available' => true,
            'category_id' => $category->id,
        ]);

        return response()->json([
        'status' => true,
        'message' => 'product added',
        'product' => $product
        ], 201);

    }

   
    public function show(string $id)
    {
         $user = Auth::user();
        $Pro = $user->products()->find($id);

        if (!$Pro) {
            return response()->json([
                'message' => 'product is not found'
            ], 404);
        }

        return response()->json([
            'product' => $Pro
        ]);
    }

   
    public function update(Request $request, $id)
    {


     $product = Product::where('id', $id)->where('user_id', auth()->id())->first();

    if (!$product) {
        return response()->json([
        'status' => false,
        'message' => 'not found'
        ], 404);
    }

     $validator = Validator::make($request->all(), [
        'name' => ['sometimes','max:255'],
        'description' => ['sometimes'],
        'price' => ['sometimes','numeric','min:0'],
        'image' => ['sometimes','image'],
        'is_available' => ['sometimes','boolean'],
        'category_name' => ['sometimes','string'],
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
    }

    
     $product->name = $request->name ?? $product->name;
    $product->price = $request->price ?? $product->price;
    $product->description = $request->description ?? $product->description;
    $product->is_available = $request->has('is_available') ? $request->is_available : $product->is_available;

    if ($request->hasFile('image')) {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->image = $request->file('image')->store('products_images', 'public');
    }

    if ($request->category_name) {
        $category = Category::firstOrCreate(['name' => $request->category_name]);
        $product->category_id = $category->id;
    }

    $product->save();

    return response()->json([
        'status' => true,
        'message' => 'updated completed',
        'product' => $product
    ]);
        // $user = Auth::user();
        // $Pro = $user->products()->find($id);

        // if (!$Pro) {
        //     return response()->json([
        //         'message' => 'product is not found'
        //     ], 404);
        // }

        // $inputs = $request->validate([
        //     'name' => ['sometimes','max:255'],
        //     'description' => ['sometimes'],
        //     'price' => ['sometimes','numeric','min:0'],
        //     'image' => ['nullable'],
        //     'is_available' => ['sometimes','boolean'],
        //     'category_id' => ['sometimes','exists:categories,id'],
        // ]);

        // $Pro->update($inputs);

        // return response()->json([
        //     'message' => 'product updated',
        //     'product' => $Pro
        // ]);
    }

   
    public function destroy(string $id)
    {
         $user = Auth::user();
        $Pro = $user->products()->find($id);

        if (!$Pro) {
            return response()->json([
                'message' => 'product is not found'
            ], 404);
        }

        $Pro->delete();

        return response()->json([
            'message' => 'product is deleted'
        ]);
    }
}
