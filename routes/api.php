<?php

use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BrandController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\ClientController;
use App\Http\Controllers\Api\V1\ColorController;
use App\Http\Controllers\Api\V1\FavoriteController;
use App\Http\Controllers\Api\V1\ImageController;
use App\Http\Controllers\Api\V1\ProductsController;
use App\Http\Controllers\Api\V1\ProductVariantController;
use App\Http\Controllers\Api\V1\SizeController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/setup/admin', [AuthController::class, 'setupAdmin'])
        ->middleware('throttle:5,1')
        ->name('setup.admin');

    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::post('/clients', [ClientController::class, 'store']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        Route::get('/clients/{id}', [ClientController::class, 'show']);
        Route::put('/clients/{id}', [ClientController::class, 'update']);
        Route::delete('/clients/{id}', [ClientController::class, 'destroy']);

        Route::apiResource('users', UserController::class);
        Route::put('/users/{id}/new-password', [UserController::class, 'generateNewPass']);

        Route::get('/cart', [CartController::class, 'index']);
        Route::post('/cart', [CartController::class, 'store']);
        Route::delete('/cart/{id}', [CartController::class, 'destroy']);
        Route::patch('/cart/{id}/increment', [CartController::class, 'increment']);
        Route::patch('/cart/{id}/decrement', [CartController::class, 'decrement']);

        Route::get('/favorites', [FavoriteController::class, 'index']);
        Route::post('/favorites', [FavoriteController::class, 'store']);
        Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy']);
        Route::post('/favorites/{id}/move-to-cart', [FavoriteController::class, 'moveToCart']);

        Route::middleware('role:admin,manager')->group(function () {
            Route::get('/clients', [ClientController::class, 'index']);

            Route::apiResource('brands', BrandController::class);
            Route::apiResource('articles', ArticleController::class);
            Route::apiResource('products', ProductsController::class);
            Route::apiResource('sizes', SizeController::class);
            Route::apiResource('colors', ColorController::class);

            Route::apiResource('product-variants', ProductVariantController::class);
            Route::get('/variants/{variant}/images', [ImageController::class, 'index']);
            Route::post('/variants/{variant}/images', [ImageController::class, 'store']);
            Route::get('/images/{id}', [ImageController::class, 'show']);
            Route::put('/images/{id}', [ImageController::class, 'update']);
            Route::delete('/images/{id}', [ImageController::class, 'destroy']);
        });
    });
});
