<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/{product:slug}', [ProductController::class, 'show']);
Route::post('/addToCart', [ProductController::class, 'addToCart'])->middleware('auth');

/** guest middleware will redirect the users if the authenticated user try to manually search for these routes */
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest');
Route::get('/login', [SessionController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [SessionController::class, 'store'])->middleware('guest');

/** auth middleware will redirect the guests if they manually search for the route */
Route::post('/logout', [SessionController::class, 'destroy'])->middleware('auth');

Route::get('/cart', [CartController::class, 'index'])->middleware('auth')->name('cart');
Route::post('/cart', [CartController::class, 'store'])->middleware('auth');
// Route::get('/cart', function() {
//     return redirect()->route('login')->with('warning', 'You need to login first');
// });
Route::post('/cart', function() {
    return redirect()->route('login')->with('warning', 'You need to login first');
});

Route::get('/cart/product/{product:slug}', [CartController::class, 'show'])->middleware('auth')->name('cart.item');
Route::delete('/cart/{cart:id}', [CartController::class, 'destroy']);

