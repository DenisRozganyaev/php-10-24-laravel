<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('auth', AuthController::class)->name('auth');

Route::middleware('auth:sanctum')->group(function () {
    require __DIR__.'/versions/v1.php';
});
