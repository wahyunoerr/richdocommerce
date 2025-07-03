<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
});
