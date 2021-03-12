<?php

use App\Http\Controllers\Addresses\AddressController;
use App\Http\Controllers\Addresses\AddressShippingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Categories\CategoryController;
use App\Http\Controllers\Countries\CountryController;
use App\Http\Controllers\Orders\OrderController;
use App\Http\Controllers\PaymentMethods\PaymentMethodController;
use App\Http\Controllers\Products\ProductController;
use Illuminate\Support\Facades\Route;

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('addresses', AddressController::class);
Route::resource('countries', CountryController::class);
Route::resource('orders', OrderController::class);
Route::resource('payment-methods', PaymentMethodController::class);

Route::get('addresses/{address}/shipping', AddressShippingController::class);

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', RegisterController::class);
    Route::post('login', LoginController::class);
    Route::get('me', MeController::class);
});

Route::resource('cart', CartController::class, [
    'parameters' => [
        'cart' => 'productVariation'
    ]
]);
