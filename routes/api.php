<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('products', ProductController::class)->only(['store', 'update','destroy']);
//    Route::post('products', [ProductController::class, 'store']);
//    Route::put('products/{id}', [ProductController::class, 'update']);
//    Route::delete('products/{id}', [ProductController::class, 'destroy']);

    Route::apiResource('users', UserController::class)->only(['store', 'update','destroy']);
//    Route::post('users', [UserController::class, 'store']);
//    Route::put('users/{id}', [UserController::class, 'update']);
//    Route::delete('users/{id}', [UserController::class, 'destroy']);

    Route::apiResource('categories', CategoryController::class)->only(['store', 'update', 'destroy']);
//    Route::post('categories', [CategoryController::class, 'store']);
//    Route::put('categories/{id}', [CategoryController::class, 'update']);
//    Route::delete('categories/{id}', [CategoryController::class, 'destroy']);

    Route::apiResource('orders', OrderController::class)->only(['store', 'update', 'destroy']);
});

Route::post('/login', [AuthController::class, 'signIn']);
Route::post('/register', [AuthController::class, 'signUp']);

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);

Route::get('categories', [CategoryController::class, 'index']);

Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);

Route::get('orders', [OrderController::class, 'index']);
Route::get('orders/{id}', [OrderController::class, 'show']);
Route::get('orders/user/{userId}', [OrderController::class, 'showUserOrders']);




