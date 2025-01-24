<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Ajax\RemoveImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Http\Controllers\HomeController::class)->name('home');

Auth::routes();

Route::resource('products', \App\Http\Controllers\ProductsController::class)
    ->only(['index', 'show']);
Route::resource('categories', \App\Http\Controllers\CategoriesController::class)
    ->only(['index', 'show']);

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin|moderator'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard'); // domain/admin/ | admin.dashboard
    Route::resource('categories', \App\Http\Controllers\Admin\CategoriesController::class)
        ->except(['show']);
    Route::resource('products', \App\Http\Controllers\Admin\ProductsController::class)
        ->except(['show']);
});

Route::prefix('ajax')->name('ajax.')->group(function () {
   Route::middleware(['auth', 'role:admin|moderator'])->group(function () {
      Route::delete('images/{image}', RemoveImageController::class)->name('images.remove');
   });
});
