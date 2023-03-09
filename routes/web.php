<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\CheckoutController::class, 'index']);

Route::get('/get-products', [\App\Http\Controllers\ProductController::class, 'index']);
