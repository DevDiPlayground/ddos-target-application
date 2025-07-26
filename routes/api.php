<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->name('auth.')->controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::post('/register', 'register')->name('register');
    Route::post('/logout', 'logout')->middleware('auth:sanctum')->name('logout');
});

Route::prefix('/product')->name('product.')->controller(ProductController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->middleware('auth:sanctum')->name('store');
});