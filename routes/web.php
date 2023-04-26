<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminVendorController;
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

Route::get('/test', function() {
    return view('register.create-address');
});

Route::middleware(['update.user.analytics'])->group(function() {
    Route::get('/', [ProductController::class, 'index'])->name('home');
    Route::get('/products/suggestions', [ProductController::class, 'suggestions'])->name('products.suggestions');   /** AJAX route */
    Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
});

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

Route::middleware(['auth', 'update.user.analytics'])->group(function() {
    Route::get('/register/address/skip', [RegisterController::class, 'skipAddress'])->name('register.address.skip');
    Route::post('/register/address', [RegisterController::class, 'storeAddress'])->name('register.store.address');

    Route::delete('/logout', [SessionController::class, 'destroy'])->name('logout');

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

    Route::post('/user/address', [UserController::class, 'storeAddress'])->name('user.store.address');
    Route::delete('/{user:username}}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/{user:username}', [UserController::class, 'profile'])->name('profile');
    Route::get('/{user:username}/settings', [UserController::class, 'edit'])->name('profile.settings');
    Route::patch('/{user:username}', [UserController::class, 'update'])->name('user.update');
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
    // Route::delete('/products/{product:slug}', [VendorProductController::class, 'destroy'])->name('vendor.products.destroy');

    Route::get('/inventories', [VendorInventoryController::class, 'index'])->name('vendor.inventories');

    Route::get('/dashboard', [VendorController::class, 'index'])->name('vendor.dashboard');
    Route::get('/transactions', [VendorTransactionController::class, 'index'])->name('vendor.transactions');
    Route::get('/orders', [vendorOrdersController::class, 'index'])->name('vendor.orders');

    Route::get('/{vendor:username}', [VendorController::class, 'show'])->name('vendor.show');
    Route::get('/{vendor:username}/settings', [VendorController::class, 'show'])->name('vendor.settings');
    Route::patch('/{vendor:username}', [VendorController::class, 'update'])->name('vendor.update');
});

Route::prefix('admin')->middleware(['auth', 'admin.access'])->group(function() {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('admin.customers');
    Route::get('/customers/{user:username}', [AdminCustomerController::class, 'show'])->name('admin.customers.show');
    Route::patch('/customers/{user:username}', [AdminCustomerController::class, 'update'])->name('admin.customers.update');
    Route::delete('/customers/{user:username}', [AdminCustomerController::class, 'destroy'])->name('admin.customers.destroy');

    Route::get('/vendors', [AdminVendorController::class, 'index'])->name('admin.vendors');
    Route::get('/vendors/verification', [AdminVendorController::class, 'verify'])->name('admin.vendors.verification');
    Route::get('/vendors/{vendor:username}', [AdminVendorController::class, 'show'])->name('admin.vendors.show');
    Route::patch('/vendors/{vendor:username}', [AdminVendorController::class, 'update'])->name('admin.vendors.update');
    Route::patch('/vendors/{vendor:username}/verify', [AdminVendorController::class, 'verify'])->name('admin.vendors.verify');
    Route::delete('/vendors/{vendor:username}', [AdminVendorController::class, 'destroy'])->name('admin.vendors.destroy');

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.categories');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/categories/{category:sub_type}', [AdminCategoryController::class, 'show'])->name('admin.categories.show');
    Route::delete('/categories/{category:sub_type}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');

    Route::get('/{user:username}', [AdminController::class, 'show'])->name('admin.show');
    Route::get('/{user:username}/settings', [AdminController::class, 'show'])->name('admin.settings');
    Route::patch('/{user:username}', [AdminController::class, 'update'])->name('admin.update');
});