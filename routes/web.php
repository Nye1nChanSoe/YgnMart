<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::middleware(['guest'])->group(function() {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
});

Route::middleware(['auth'])->group(function() {
    Route::post('/logout', [SessionController::class, 'destroy']);

    Route::post('/add', [ProductController::class, 'addToCart'])->name('products.add');

    Route::get('/carts', [CartController::class, 'index'])->name('carts.index');
    Route::post('/carts', [CartController::class, 'store']);
    Route::post('/carts/checkout', [CartController::class, 'checkout'])->name('carts.checkout');
    Route::get('/carts/{product:slug}', [CartController::class, 'show'])->name('carts.show');
    Route::delete('/carts/{cart}', [CartController::class, 'destroy']);

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::delete('/checkout/{checkout}', [CheckoutController::class, 'destroy'])->name('checkout.destroy');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/success', [OrderController::class, 'success'])->name('orders.success');
    Route::get('/orders/{order:order_code}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});
