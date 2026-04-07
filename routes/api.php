<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\StateController;
use App\Http\Controllers\Api\V1\CityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/profile', [AuthController::class, 'profile']);
        });
    });

    Route::get('/countries', [CountryController::class, 'index']);
    Route::get('/states', [StateController::class, 'index']);
    Route::get('/cities', [CityController::class, 'index']);

    Route::prefix('ai')->group(function () {
        Route::get('/categories', [CategoryController::class, 'index']);
    });
});
