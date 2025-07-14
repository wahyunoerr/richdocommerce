<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'landing'])->name('landing');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// Produk untuk customer
Route::get('/products', [App\Http\Controllers\ProductController::class, 'customerIndex'])->name('products.index');
Route::get('/products/{id}', [App\Http\Controllers\ProductController::class, 'customerShow'])->name('products.show');
Route::post('/cart/add/{id}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');


Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/orders', [App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/payment/{id}', [App\Http\Controllers\OrderController::class, 'payment'])->name('orders.payment');
    Route::post('/orders/pay/{id}', [App\Http\Controllers\OrderController::class, 'pay'])->name('orders.pay');
    Route::get('/my-orders', [App\Http\Controllers\CustomerOrderController::class, 'index'])->name('customer.orders');
    Route::get('/my-orders/{id}', [App\Http\Controllers\CustomerOrderController::class, 'show'])->name('customer.orders.detail');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // CRUD Produk
    Route::get('products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
    Route::post('products', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
    Route::get('products/{id}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');
    // CRUD Kategori
    Route::get('categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{id}/edit', [App\Http\Controllers\CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{id}', [App\Http\Controllers\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.destroy');
    // CRUD Role
    Route::get('roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/create', [App\Http\Controllers\RoleController::class, 'create'])->name('roles.create');
    Route::post('roles', [App\Http\Controllers\RoleController::class, 'store'])->name('roles.store');
    Route::get('roles/{id}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('roles.edit');
    Route::put('roles/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('roles.update');
    Route::delete('roles/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('roles.destroy');
    // CRUD User
    Route::get('users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::get('users/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    // CRUD Orders
    Route::get('orders', [App\Http\Controllers\AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [App\Http\Controllers\AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{id}/update', [App\Http\Controllers\AdminOrderController::class, 'update'])->name('orders.update');
    Route::post('orders/{id}/delete', [App\Http\Controllers\AdminOrderController::class, 'destroy'])->name('orders.destroy');
    // Mutasi Stok
    Route::get('mutasi-stok', [\App\Http\Controllers\MutasiStockController::class, 'index'])->name('mutasi.index');
    Route::get('mutasi-stok/create', [\App\Http\Controllers\MutasiStockController::class, 'create'])->name('mutasi.create');
    Route::post('mutasi-stok', [\App\Http\Controllers\MutasiStockController::class, 'store'])->name('mutasi.store');
    Route::get('mutasi-stok/report', [\App\Http\Controllers\MutasiStockController::class, 'report'])->name('mutasi.report');
});
