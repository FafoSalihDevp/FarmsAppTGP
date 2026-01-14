<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\CustomerCartController;
use App\Http\Controllers\Customer\CustomerCategoryController;
use App\Http\Controllers\Customer\CustomerControlller;
use App\Http\Controllers\Customer\CustomerOrderController;
use App\Http\Controllers\Customer\CustomerProductController;
use App\Http\Controllers\Farmer\FarmerCategoryController;
use App\Http\Controllers\Farmer\FarmerController;
use App\Http\Controllers\Farmer\FarmerOrderController;
use App\Http\Controllers\Farmer\FarmerProductController;
// use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//  -------- Login -------- 
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:3,1');;


// --------- Loged out ----------
Route::middleware('auth:sanctum')->group(function () {

Route::post("/logout" , [AuthController::class, 'logout']);
});


// --------- Farmer Route  ----------

// Route::prefix('farmer')->middleware('auth:sanctum')->group(function() {
//     // ====== register =======
//     Route::post('/register', [FarmerController::class, 'register']);

//     // ====== product & category =======
//     Route::apiResource('product', FarmerProductController::class);
//     Route::apiResource('category',FarmerCategoryController::class)->only('index');

//     // ====== order =======
//     Route::get('/order', [FarmerOrderController::class, 'showOrder']);
//     Route::put('/order/{id}/status', [FarmerOrderController::class, 'updateStatus']);

// --------- Farmer Route  ----------
Route::prefix('farmer')->group(function () {
    // ====== register =======
    Route::post('/register', [FarmerController::class, 'register']);
    
    Route::middleware('auth:sanctum')->group(function () {
        // ====== product & category =======
        Route::apiResource('product', FarmerProductController::class);
        Route::apiResource('category', FarmerCategoryController::class)->only('index');
    // ====== order =======
        Route::get('/order', [FarmerOrderController::class, 'showOrder']);
        Route::put('/order/{id}/status', [FarmerOrderController::class, 'updateStatus']);
    });
});


// --------- Customer Route  ----------
Route::prefix('customer')->group(function () {
    // ====== register =======
    Route::post('/register', [CustomerControlller::class, 'register']);
  
    Route::middleware('auth:sanctum')->group(function () {
         // ====== product & category =======
       Route::apiResource('product', CustomerProductController::class);
       Route::apiResource('category',CustomerCategoryController::class)->only('index');
     // ====== carts =======
      Route::get('/cart', [CustomerCartController::class, 'myCart']);
      Route::post('/cart/add', [CustomerCartController::class,'addToCart']);
      Route::delete('/cart/item/{id}', [CustomerCartController::class,'removeItem']);
    // ====== orders =======
     Route::post('/checkout', [CustomerOrderController::class, 'checkout']);
     Route::get('/myorders', [CustomerOrderController::class, 'myOrders']);
     Route::get('/orderdetails/{id}', [CustomerOrderController::class, 'orderDetails']);
    });
});



