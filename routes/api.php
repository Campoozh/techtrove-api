<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\OrderController;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'signIn']);
Route::post('/register', [AuthController::class, 'signUp']);

Route::apiResource('products', ProductController::class);
//Route::get('products', [ProductController::class, 'index']);
//Route::post('products', [ProductController::class, 'store']);
//Route::get('products/{id}', [ProductController::class, 'show']);
//Route::put('products/{id}', [ProductController::class, 'update']);
//Route::delete('products/{id}', [ProductController::class, 'delete']);

Route::apiResource('categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
//Route::get('categories', [CategoryController::class, 'index']);
//Route::post('categories', [CategoryController::class, 'store']);
//Route::put('categories/{id}', [CategoryController::class, 'update']);
//Route::delete('categories/{id}', [CategoryController::class, 'delete']);

Route::apiResource('users', UserController::class)->only(['index', 'show', 'update','destroy']);
//Route::get('users', [UserController::class, 'index']);
//Route::post('users', [UserController::class, 'store']);
//Route::get('users/{id}', [UserController::class, 'show']);
//Route::put('users/{id}', [UserController::class, 'update']);
//Route::delete('users/{id}', [UserController::class, 'delete']);

Route::apiResource('orders', OrderController::class);


