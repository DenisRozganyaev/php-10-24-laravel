<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Ajax\AddToCartController;
use App\Http\Controllers\Ajax\Payments\PaypalController;
use App\Http\Controllers\Ajax\Payments\StripeController;
use App\Http\Controllers\Ajax\RemoveImageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\InvoiceController;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

Route::get('test', function () {
    logs()->info('route test');

    $order = Order::take(1)->first();
    \App\Events\OrderCreatedEvent::dispatch($order);
});
Route::get('/', \App\Http\Controllers\HomeController::class)->name('home');

Auth::routes();

Route::resource('products', \App\Http\Controllers\ProductsController::class)
    ->only(['index', 'show']);
Route::resource('categories', \App\Http\Controllers\CategoriesController::class)
    ->only(['index', 'show']);

Route::get('/orders/{vendor_order_id}/thank-you', \App\Http\Controllers\Pages\ThankYouController::class)->name('order.thank-you');
Route::get('checkout', CheckoutController::class)->name('checkout');
Route::name('cart.')->prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::delete('/', [CartController::class, 'remove'])->name('remove');
    Route::post('{product}', [CartController::class, 'add'])->name('add');
    Route::put('{product}', [CartController::class, 'update'])->name('update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('orders/{vendor_order_id}/invoice', InvoiceController::class)->name('order.invoice');

    Route::prefix('products')->name('products.')->group(function () {
        Route::post('{product}/wishlist', [\App\Http\Controllers\WishListController::class, 'add'])
            ->name('wishlist.add');
        Route::delete('{product}/wishlist', [\App\Http\Controllers\WishListController::class, 'remove'])
            ->name('wishlist.remove');
    });
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin|moderator'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard'); // domain/admin/ | admin.dashboard
    Route::resource('categories', \App\Http\Controllers\Admin\CategoriesController::class)
        ->except(['show']);
    Route::resource('products', \App\Http\Controllers\Admin\ProductsController::class)
        ->except(['show']);
    Route::get('products/export', [\App\Http\Controllers\Admin\ProductsController::class, 'export'])->name('products.export');
});

Route::prefix('ajax')->name('ajax.')->group(function () {
    Route::post('cart/{product}', AddToCartController::class)->name('cart.add');

    Route::middleware(['auth', 'role:admin|moderator'])->group(function () {
        Route::delete('images/{image}', RemoveImageController::class)->name('images.remove');
    });

    Route::prefix('paypal')->name('paypal.')->group(function () {
       Route::post('order', [PayPalController::class, 'create'])->name('order.create');
       Route::post('order/{vendorOrderId}/capture', [PayPalController::class, 'capture'])->name('order.capture');
    });

    Route::post('stripe/order', [StripeController::class, 'create'])->name('stripe.order.create');
});

Route::prefix('account')->name('account.')->middleware(['auth'])->group(function () {
    Route::get('wishlist', \App\Http\Controllers\Account\WishListController::class)->name('wishlist');
});
