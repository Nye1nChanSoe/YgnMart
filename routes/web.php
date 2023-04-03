<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorInventoryController;
use App\Http\Controllers\vendorOrdersController;
use App\Http\Controllers\VendorProductController;
use App\Http\Controllers\VendorTransactionController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/suggestions', [ProductController::class, 'suggestions'])->name('products.suggestions');   /** AJAX route */
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
// Route::get('/products/vendor/{vendor:username}')


Route::middleware(['guest'])->group(function() {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
});

Route::prefix('vendor')->middleware(['guest'])->group(function() {
    Route::get('/register', [RegisterController::class, 'vcreate'])->name('vendor.register');
    Route::post('/register', [RegisterController::class, 'vstore']);
    Route::get('/login', [SessionController::class, 'vcreate'])->name('vendor.login');
    Route::post('/login', [SessionController::class, 'vstore']);
});

Route::middleware(['auth'])->group(function() {
    Route::get('/register/address/skip', [RegisterController::class, 'skipAddress'])->name('register.address.skip');
    Route::post('/register/address', [RegisterController::class, 'storeAddress'])->name('register.store.address');

    Route::delete('/logout', [SessionController::class, 'destroy']);

    Route::post('/add', [ProductController::class, 'addToCart'])->name('products.add');

    Route::get('/carts', [CartController::class, 'index'])->name('carts.index');
    Route::post('/carts', [CartController::class, 'store']);
    Route::post('/carts/checkout', [CartController::class, 'checkout'])->name('carts.checkout');
    Route::get('/carts/{product:slug}', [CartController::class, 'show'])->name('carts.show');
    Route::put('/carts/{cart}', [CartController::class, 'update']);
    Route::delete('/carts/{cart}', [CartController::class, 'destroy']);

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::delete('/checkout/{checkout}', [CheckoutController::class, 'destroy'])->name('checkout.destroy');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/success', [OrderController::class, 'success'])->name('orders.success');
    Route::get('/orders/{order:order_code}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    Route::post('/products/{product:id}/review', [ProductController::class, 'review'])->name('products.review');
    Route::patch('/products/{product:id}/review', [ProductController::class, 'update'])->name('products.review.update');

    Route::post('/address', [AddressController::class, 'store'])->name('address.store');
    Route::patch('/address', [AddressController::class, 'update'])->name('address.update');
    Route::delete('/address', [AddressController::class, 'destroy'])->name('address.destroy');

    Route::patch('/user/password', [UserController::class, 'update'])->name('user.update.password');
    Route::patch('/user', [UserController::class, 'update'])->name('user.update.info');
    Route::post('/user/address', [UserController::class, 'storeAddress'])->name('user.store.address');
    Route::delete('/user', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/{user:username}', [UserController::class, 'profile'])->name('profile');
    Route::get('/{user:username}/settings', [UserController::class, 'edit'])->name('profile.settings');
    Route::get('/{user:username}/help', [UserController::class, 'profile'])->name('profile.help');
    Route::get('/{user:username}/privacy', [UserController::class, 'profile'])->name('profile.privacy');
});

Route::prefix('vendor')->middleware(['auth:vendor'])->group(function() {
    Route::delete('/logout', [SessionController::class, 'vdestroy'])->name('vendor.logout');

    Route::get('/products', [VendorProductController::class, 'index'])->name('vendor.products');
    Route::post('/products', [VendorProductController::class, 'store'])->name('vendor.products.store');
    Route::get('/products/create', [VendorProductController::class, 'create'])->name('vendor.products.create');
    Route::get('/products/{product:slug}', [VendorProductController::class, 'show'])->name('vendor.products.show');
    Route::get('/products/{product:slug}/edit', [VendorProductController::class, 'edit'])->name('vendor.products.edit');
    Route::put('/products/{product:slug}', [VendorProductController::class, 'update'])->name('vendor.products.update');
    Route::delete('/products/{product:slug}', [VendorProductController::class, 'destroy'])->name('vendor.products.destroy');
    
    Route::get('/inventories', [VendorInventoryController::class, 'index'])->name('vendor.inventories');

    Route::get('/dashboard', [VendorController::class, 'index'])->name('vendor.dashboard');
    Route::get('/transactions', [VendorTransactionController::class, 'index'])->name('vendor.transactions');
    Route::get('/orders', [vendorOrdersController::class, 'index'])->name('vendor.orders');
    Route::get('/{vendor:username}', [VendorController::class, 'show'])->name('vendor.show');
    Route::get('/settings', [VendorController::class, 'edit'])->name('vendor.settings');
});