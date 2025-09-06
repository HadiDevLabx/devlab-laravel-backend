<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'laravel API',
        'version' => '1.0.0',
        'status' => 'active',
        'endpoints' => [
            'auth' => '/api/login',
            'products' => '/api/products',
            'categories' => '/api/categories',
            'cart' => '/api/cart',
            'orders' => '/api/orders'
        ]
    ]);
});
