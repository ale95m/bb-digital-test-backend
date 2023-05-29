<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::get('logout', [AuthController::class, 'logout']);

Route::prefix('products')->group(function () {
    Route::get('', [ProductController::class, 'paginate']);
    Route::get('get/count', [ProductController::class, 'count']);
    Route::get('get/out_of_stock', [ProductController::class, 'outOfStock']);
    Route::get('{product}', [ProductController::class, 'show']);
    Route::post('sell/{product}', [ProductController::class, 'sell']);
});

Route::prefix('sales')->group(function () {
    Route::get('', [SaleController::class, 'index']);
    Route::get('total', [SaleController::class, 'total']);

});

Route::apiResource('products', ProductController::class)->except('index', 'show');
