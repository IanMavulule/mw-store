<?php

use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BrandController;
use App\Http\Controllers\Api\V1\ColorController;
use App\Http\Controllers\Api\V1\ProductsController;
use App\Http\Controllers\Api\V1\SizeController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/setup/admin', [AuthController::class, 'setupAdmin'])
        ->middleware('throttle:5,1')
        ->name('setup.admin');

    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        Route::apiResource('users', UserController::class);
        Route::put('/users/{id}/new-password', [UserController::class, 'generateNewPass']);

        Route::middleware('role:admin,manager')->group(function () {
            Route::apiResource('brands', BrandController::class);
            Route::apiResource('articles', ArticleController::class);
            Route::apiResource('products', ProductsController::class);
            Route::apiResource('sizes', SizeController::class);
            Route::apiResource('colors', ColorController::class);
        });
    });
});
